<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use Exception;
use Facile\JoseVerifier\Exception\InvalidTokenException;
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

use function count;

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
        // 2. Get the AT Token and submit for introspection to EU Login.
        // 3. With the response, get the public key and verify the pop token.

        // Step 0.
        $token = $this->getToken($request);

        // Step 1.
        $accessToken = $this->getAccessToken($token);

        // Step 2.
        $response = $this
            ->getIntrospectionService()
            ->introspect(
                $this->getOpenIdClient(),
                $accessToken
            );

        // Step 3.
        // Do the Access Token verification. (mandatory)
        // We cannot use AccessTokenVerifierBuilder because it checks
        // for mandatory claims. The token we are verifying doesn't have
        // those claims.

        // Return the payload if successful. Throws otherwise.
        try {
            $this->getTokenVerifier($response)->verify($token);
        } catch (InvalidTokenException $e) {
            throw $e;
        }

        return $response;
    }

    public function hasPopToken(RequestInterface $request): bool
    {
        if (false === $request->hasHeader('Authorization')) {
            return false;
        }

        $headerParts = explode(' ', $request->getHeaderLine('Authorization'));

        if (2 !== count($headerParts)) {
            return false;
        }

        if ('pop' !== $headerParts[0]) {
            return false;
        }

        if (3 !== count(explode('.', $headerParts[1]))) {
            return false;
        }

        return true;
    }

    private function getAccessToken(string $popToken): string
    {
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

        return $payload->at;
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

        $metadataProviderBuilder = (new MetadataProviderBuilder())
            ->setHttpClient($this->client);

        return (new IssuerBuilder())
            ->setJwksProviderBuilder($this->getJwksProviderBuilder())
            ->setMetadataProviderBuilder($metadataProviderBuilder)
            ->build($configuration['environment']);
    }

    private function getJwksProviderBuilder(): JwksProviderBuilder
    {
        return (new JwksProviderBuilder())
            ->setHttpClient($this->client);
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

    private function getToken(RequestInterface $request): string
    {
        if (false === $this->hasPopToken($request)) {
            throw new Exception('Unable to get the token from the request.');
        }

        return mb_substr($request->getHeaderLine('Authorization'), 4);
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
            throw new Exception('Wrong environment.');
        }

        return $configuration;
    }
}
