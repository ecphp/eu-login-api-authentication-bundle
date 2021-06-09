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
use EcPhp\EuLoginApiAuthenticationBundle\Security\EuLoginApiAuthenticationGuardAuthenticator;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentials;
use EcPhp\EuLoginApiAuthenticationBundle\Service\EuLoginApiCredentialsInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;

return static function (ContainerConfigurator $container) {
    $container
        ->services()
        ->set(PsrHttpFactory::class)
        ->autowire(true)
        ->autoconfigure(true);

    $container
        ->services()
        ->alias(HttpMessageFactoryInterface::class, PsrHttpFactory::class);

    $container
        ->services()
        ->set('eu_login_api_authentication.guard', EuLoginApiAuthenticationGuardAuthenticator::class)
        ->autowire(true)
        ->autoconfigure(true);

    $container
        ->services()
        ->set('eu_login_api_authentication.service', EuLoginApiCredentials::class)
        ->arg('$configuration', '%eu_login_api_authentication%')
        ->autowire(true)
        ->autoconfigure(true);

    $container
        ->services()
        ->set('eu_login_api_authentication.user_provider', EuLoginApiAuthenticationUserProvider::class)
        ->autowire(true)
        ->autoconfigure(true);

    $container
        ->services()
        ->alias(EuLoginApiCredentialsInterface::class, 'eu_login_api_authentication.service');

    $container
        ->services()->load('EcPhp\\EuLoginApiAuthenticationBundle\\Controller\\', __DIR__ . '/../../Controller')
        ->autowire(true)
        ->autoconfigure(true)
        ->tag('controller.service_arguments');
};
