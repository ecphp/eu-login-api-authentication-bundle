<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Security;

use EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User\EuLoginApiAuthenticationUserProviderInterface;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentialsInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Throwable;

final class EuLoginApiAuthenticationAuthenticator extends AbstractAuthenticator
{
    private EuLoginApiAuthenticationUserProviderInterface $euLoginApiAuthenticationUserProvider;

    private EuLoginApiCredentialsInterface $euLoginApiCredentials;

    private HttpMessageFactoryInterface $httpMessageFactory;

    public function __construct(
        HttpMessageFactoryInterface $httpMessageFactory,
        EuLoginApiCredentialsInterface $euLoginApiCredentials,
        EuLoginApiAuthenticationUserProviderInterface $euLoginApiAuthenticationUserProvider
    ) {
        $this->httpMessageFactory = $httpMessageFactory;
        $this->euLoginApiCredentials = $euLoginApiCredentials;
        $this->euLoginApiAuthenticationUserProvider = $euLoginApiAuthenticationUserProvider;
    }

    public function authenticate(Request $request): Passport
    {
        try {
            $payload = $this->euLoginApiCredentials->getCredentials($this->toPsr($request));
        } catch (Throwable $e) {
            throw new AuthenticationException('Unable to get credentials.', 0, $e);
        }

        return new SelfValidatingPassport(
            new UserBadge(
                $payload['sub'],
                static fn (string $identifier): UserInterface => $this->euLoginApiAuthenticationUserProvider->loadUserByUsernameAndPayload($identifier, $payload)
            )
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('Authentication failed', 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function supports(Request $request): bool
    {
        return $this->euLoginApiCredentials->hasPopToken($this->toPsr($request));
    }

    /**
     * Convert a Symfony request into a PSR Request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The Symfony request.
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     *   The PSR request.
     */
    private function toPsr(Request $request): ServerRequestInterface
    {
        // As we cannot decorate the Symfony Request object, we convert it into
        // a PSR Request so we can override the PSR HTTP Message factory if
        // needed.
        // See the reasons at https://github.com/ecphp/cas-lib/issues/5
        return $this->httpMessageFactory->createRequest($request);
    }
}
