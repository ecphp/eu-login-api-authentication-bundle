<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User\EuLoginApiAuthenticationUserProvider;
use EcPhp\EuLoginApiAuthenticationBundle\Security\Core\User\EuLoginApiAuthenticationUserProviderInterface;
use EcPhp\EuLoginApiAuthenticationBundle\Security\EuLoginApiAuthenticationAuthenticator;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentials;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentialsInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

return static function (ContainerConfigurator $container) {
    $services = $container
        ->services();

    $services
        ->defaults()
        ->autoconfigure(true)
        ->autowire(true);

    $services
        ->set(PsrHttpFactory::class);

    $services
        ->alias(HttpMessageFactoryInterface::class, PsrHttpFactory::class);

    $services
        ->set(EuLoginApiAuthenticationUserProvider::class);

    $services
        ->alias(EuLoginApiAuthenticationUserProviderInterface::class, EuLoginApiAuthenticationUserProvider::class);

    $services
        ->set('eu_login_api_authentication.authenticator', EuLoginApiAuthenticationAuthenticator::class);

    $services
        ->set('eu_login_api_authentication.service', EuLoginApiCredentials::class)
        ->arg('$configuration', '%eu_login_api_authentication%');

    $services
        ->alias(EuLoginApiCredentialsInterface::class, 'eu_login_api_authentication.service');

    $services
        ->load('EcPhp\\EuLoginApiAuthenticationBundle\\Controller\\', __DIR__ . '/../../Controller')
        ->tag('controller.service_arguments');
};
