<?php

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

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request): array
    {
        return $this->euLoginApiCredentials->getCredentials($this->toPsr($request));
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        /** @var EuLoginApiAuthenticationUserProviderInterface $userProvider */
        return $userProvider->loadUserByUsernameAndPayload($credentials['sub'], $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new Response('Auth header required', 401);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new Response('Auth header required', 401);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request): bool
    {
        return $this->euLoginApiCredentials->hasPopToken($this->toPsr($request));
    }

    /**
     * {@inheritdoc}
     */
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
