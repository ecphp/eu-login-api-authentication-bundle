<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use EcPhp\EuLoginApiAuthenticationBundle\Exception\EuLoginApiAuthenticationException;
use Facile\JoseVerifier\JWK\JwksProviderBuilder;
use Facile\JoseVerifier\JWK\MemoryJwksProvider;
use Facile\JoseVerifier\TokenVerifierInterface;
use Facile\OpenIDClient\Client\ClientBuilder;
use Facile\OpenIDClient\Client\ClientInterface as ClientClientInterface;
use Facile\OpenIDClient\Client\Metadata\ClientMetadata;
use Facile\OpenIDClient\Client\Metadata\ClientMetadataInterface;
use Facile\OpenIDClient\Issuer\IssuerBuilder;
use Facile\OpenIDClient\Issuer\IssuerInterface;
use Facile\OpenIDClient\Issuer\Metadata\Provider\MetadataProviderBuilder;
use Facile\OpenIDClient\Service\Builder\IntrospectionServiceBuilder;
use Facile\OpenIDClient\Service\IntrospectionService;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

use function array_key_exists;
use function count;
use function is_object;

final class EuLoginApiCredentials implements EuLoginApiCredentialsInterface
{
    private const EU_LOGIN_ENVS = [
        'acceptance' => 'https://ecas.acceptance.ec.europa.eu/cas/oauth2/.well-known/openid-configuration',
        'production' => 'https://ecas.ec.europa.eu/cas/oauth2/.well-known/openid-configuration',
    ];

    private ClientInterface $client;

    private array $configuration;

    public function __construct(ClientInterface $client, array $configuration = [])
    {
        $this->client = $client;
        $this->configuration = $this->updateConfiguration($configuration);
    }

    public function getCredentials(RequestInterface $request): array
    {
        // 0. Get the pop token from the request.
        // 1. Decode the payload of the pop token.
        // 2. Get the AT Token from the payload and submit it for introspection to EU Login.
        // 3. From the response, get the public key and verify the pop token signature.
        // 4. Return the response claims if the signature match.

        // Step 0.
        try {
            $token = $this->getPopToken($request);
        } catch (Throwable $e) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials($e);
        }

        // Step 1.
        try {
            $accessToken = $this->getAccessToken($token);
        } catch (Throwable $e) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials($e);
        }

        // Step 2.
        try {
            $response = $this
                ->getIntrospectionService()
                ->introspect(
                    $this->getOpenIdClient(),
                    $accessToken
                );
        } catch (Throwable $e) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials(
                EuLoginApiAuthenticationException::unableToIntrospectAccessToken(
                    $this->getOpenIdClient()->getIssuer()->getMetadata()->getIntrospectionEndpoint(),
                    $accessToken,
                    $this->configuration['environment'],
                    $e
                )
            );
        }

        if (false === array_key_exists('active', $response)) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials(
                EuLoginApiAuthenticationException::invalidIntrospectionEndpointResponse()
            );
        }

        if (false === $response['active']) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials(
                EuLoginApiAuthenticationException::invalidOrRevokedToken()
            );
        }

        // TODO: Should we add a check to filter the audience ('aud' claim),
        // TODO: against a list from the configuration?
        /*
        if ($this->configuration['audience'] !== []) {
            if (false === in_array($response['aud'], $this->configuration['audience'], true)) {
                throw ...;
            }
        }
         */

        // Step 3.
        // Do the Access Token verification. (mandatory)
        // We cannot use AccessTokenVerifierBuilder because it checks
        // for mandatory claims. The token we are verifying doesn't have
        // those claims.

        // Return the payload if successful. Throws otherwise.
        try {
            $this->getTokenVerifier($response)->verify($token);
        } catch (Throwable $e) {
            throw EuLoginApiAuthenticationException::unableToGetCredentials(
                EuLoginApiAuthenticationException::unableToVerifyToken($token, $e)
            );
        }

        // TODO: Should we do something with the the $payload->ts claim?

        return $response;
    }

    public function hasPopToken(RequestInterface $request): bool
    {
        try {
            $this->getPopToken($request);
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }

    private function getAccessToken(string $popToken): string
    {
        try {
            [, $payload,] = array_map(
                'json_decode',
                array_map(
                    'base64_decode',
                    explode(
                        '.',
                        $popToken,
                        3
                    )
                )
            );
        } catch (Throwable $e) {
            throw EuLoginApiAuthenticationException::unableToGetAccessTokenFromPopToken($popToken, $e);
        }

        if (is_object($payload) && property_exists($payload, 'at')) {
            return $payload->at;
        }

        throw EuLoginApiAuthenticationException::unableToGetAccessTokenFromPopToken($popToken);
    }

    private function getClientMetadata(): ClientMetadataInterface
    {
        $configuration = $this->configuration;

        return ClientMetadata::fromArray([
            'client_id' => $configuration['client_id'],
            'client_secret' => $configuration['client_secret'],
            'token_endpoint_auth_method' => 'client_secret_jwt',
        ]);
    }

    private function getIntrospectionService(): IntrospectionService
    {
        return (new IntrospectionServiceBuilder())
            ->setHttpClient($this->client)
            ->build();
    }

    private function getIssuer(): IssuerInterface
    {
        $configuration = $this->configuration;

        return (new IssuerBuilder())
            ->setJwksProviderBuilder($this->getJwksProviderBuilder())
            ->setMetadataProviderBuilder((new MetadataProviderBuilder())->setHttpClient($this->client))
            ->build($configuration['environment']);
    }

    private function getJwksProviderBuilder(): JwksProviderBuilder
    {
        return (new JwksProviderBuilder())->setHttpClient($this->client);
    }

    private function getOpenIdClient(): ClientClientInterface
    {
        return (new ClientBuilder())
            ->setJwksProvider($this->getJwksProviderBuilder()->build())
            ->setHttpClient($this->client)
            ->setIssuer($this->getIssuer())
            ->setClientMetadata($this->getClientMetadata())
            ->build();
    }

    private function getPopToken(RequestInterface $request): string
    {
        if (false === $request->hasHeader('Authorization')) {
            throw EuLoginApiAuthenticationException::noAuthorizationHeaderInRequest($request);
        }

        $headerParts = explode(' ', $request->getHeaderLine('Authorization'));

        if (2 !== count($headerParts)) {
            throw EuLoginApiAuthenticationException::invalidAuthorizationHeader($headerParts);
        }

        if ('pop' !== $headerParts[0]) {
            throw EuLoginApiAuthenticationException::invalidAuthorizationHeaderPrefix($headerParts[0]);
        }

        if (3 !== count(explode('.', $headerParts[1]))) {
            throw EuLoginApiAuthenticationException::invalidJWTTokenStructure($headerParts[1]);
        }

        return $headerParts[1];
    }

    private function getTokenVerifier(array $payload): TokenVerifierInterface
    {
        $verifierBuilder = new EuLoginApiAccessTokenVerifierBuilder();

        $verifierBuilder->setIssuerMetadata($this->getIssuer()->getMetadata()->toArray());
        $verifierBuilder->setClientMetadata($this->getClientMetadata()->toArray());
        $verifierBuilder->setJwksProvider(new MemoryJwksProvider([
            'keys' => $payload['cnf'],
        ]));

        return $verifierBuilder->build();
    }

    private function updateConfiguration(array $configuration): array
    {
        $configuration['environment'] = self::EU_LOGIN_ENVS[$configuration['environment']] ?? '';

        if ('' === $configuration['environment']) {
            throw EuLoginApiAuthenticationException::invalidEuLoginEnvironment($configuration['environment']);
        }

        return $configuration;
    }
}
