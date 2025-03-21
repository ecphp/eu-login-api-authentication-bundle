<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Service;

use EcPhp\EuLoginApiAuthenticationBundle\Exception\EuLoginApiAuthenticationException;
use Override;
use Psr\Http\Message\RequestInterface;
use Throwable;

use function array_key_exists;
use function count;
use function is_object;

final class LocalEuLoginApiCredentials implements EuLoginApiCredentialsInterface
{
    private EuLoginApiCredentialsInterface $euLoginApiCredentials;

    public function __construct(EuLoginApiCredentialsInterface $euLoginApiCredentials)
    {
        $this->euLoginApiCredentials = $euLoginApiCredentials;
    }

    #[Override]
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
        [, $payload] = array_map(
            'json_decode',
            array_map(
                'base64_decode',
                explode(
                    '.',
                    $accessToken,
                    3
                )
            )
        );
        $response = (array) $payload;

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

        // Step 3 is skipped.

        // Step 4.
        return (array) $payload;
    }

    #[Override]
    public function hasPopToken(RequestInterface $request): bool
    {
        return $this->euLoginApiCredentials->hasPopToken($request);
    }

    private function getAccessToken(string $popToken): string
    {
        try {
            [, $payload] = array_map(
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
}
