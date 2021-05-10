<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
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
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Throwable;

final class EuLoginApiAuthenticationGuardAuthenticator extends AbstractGuardAuthenticator
{
    private EuLoginApiCredentialsInterface $euLoginApiCredentials;

    private HttpMessageFactoryInterface $httpMessageFactory;

    public function __construct(
        HttpMessageFactoryInterface $httpMessageFactory,
        EuLoginApiCredentialsInterface $euLoginApiCredentials
    ) {
        $this->httpMessageFactory = $httpMessageFactory;
        $this->euLoginApiCredentials = $euLoginApiCredentials;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function getCredentials(Request $request): array
    {
        try {
            $credentials = $this->euLoginApiCredentials->getCredentials($this->toPsr($request));
        } catch (Throwable $e) {
            throw new AuthenticationException('Unable to get credentials.', 0, $e);
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        /** @var EuLoginApiAuthenticationUserProviderInterface $userProvider */
        return $userProvider->loadUserByUsernameAndPayload($credentials['sub'], $credentials);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('Authentication failed', 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new Response('Authentication failed', 401);
    }

    public function supports(Request $request): bool
    {
        return $this->euLoginApiCredentials->hasPopToken($this->toPsr($request));
    }

    public function supportsRememberMe(): bool
    {
        return false;
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
