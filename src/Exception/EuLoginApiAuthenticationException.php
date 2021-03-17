<?php

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;
use Throwable;

use function count;

final class EuLoginApiAuthenticationException extends Exception
{
    public static function invalidAuthorizationHeader(array $headerParts): self
    {
        $message = 'It seems that the "Authorization" header of the incoming request is invalid(%s),
        it is supposed to contains 2 parts and it actually has %s.';

        return new self(sprintf($message, implode(' ', $headerParts), count($headerParts)));
    }

    public static function invalidAuthorizationHeaderPrefix(string $authorizationHeaderPrefix): self
    {
        $message = 'It seems that the "Authorization" header prefix of the incoming request is invalid,
        it is supposed to be "pop" and it actually is: "%s"';

        return new self(sprintf($message, $authorizationHeaderPrefix));
    }

    public static function invalidEuLoginEnvironment(string $environment, ?Throwable $previous = null): self
    {
        $message = 'The EU Login environment in the provided configuration is invalid(%s).';

        return new self(sprintf($message, $environment), 0, $previous);
    }

    public static function invalidIntrospostionEndpointResponse(): self
    {
        $message = 'The introspection response is supposed to contains an "active" key and it does not.';

        return new self($message);
    }

    public static function invalidJWTTokenStructure(string $jwt): self
    {
        $message = 'It seems that the "Authorization" header of the incoming request is invalid,
        it is supposed to be contains 3 parts separated by a dot(%s).';

        return new self(sprintf($message, $jwt));
    }

    public static function invalidOrRevokedToken(): self
    {
        $message = 'The introspection response is supposed to contains an "active" key set to "true" and it does not.';

        return new self($message);
    }

    public static function noAuthorizationHeaderInRequest(RequestInterface $request, ?Throwable $previous = null): self
    {
        $message = 'It seems that the incoming request does not contains an "Authorization" header.';

        return new self($message, 0, $previous);
    }

    public static function unableToGetAccessTokenFromPopToken(string $popToken, ?Throwable $previous = null): self
    {
        $message = 'Unable to get an Access Token from the given Pop Token(%s).';

        return new self(sprintf($message, $popToken), 0, $previous);
    }

    public static function unableToGetCredentials(?Throwable $previous = null): self
    {
        $message = 'Unable to get credentials from the given request.';

        return new self($message, 0, $previous);
    }

    public static function unableToGetPopTokenFromRequest(RequestInterface $request, ?Throwable $previous = null): self
    {
        $message = 'It seems that the incoming request does not contains a valid token.';

        return new self($message, 0, $previous);
    }

    public static function unableToIntrospectAccessToken(
        string $accessToken,
        string $introspectionEndpoint,
        string $environment,
        ?Throwable $previous = null
    ): self {
        $message = 'Unable to make a proper request at %s(%s) to introspect the Access Token(%s).';

        return new self(sprintf($message, $introspectionEndpoint, $environment, $accessToken), 0, $previous);
    }

    public static function unableToVerifyToken(string $token, ?Throwable $previous = null): self
    {
        $message = 'Unable to verify the signature of the given token(%s)';

        return new self(sprintf($message, $token), 0, $previous);
    }
}
