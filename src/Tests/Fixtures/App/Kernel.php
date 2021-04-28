<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\Tests\Fixtures\App;

use Ajgarlag\Bundle\PsrHttpMessageBundle\AjgarlagPsrHttpMessageBundle;
use EcPhp\EuLoginApiAuthenticationBundle\EuLoginApiAuthenticationBundle;
use FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles()
    {
        return [
            new MonologBundle(),
            new AjgarlagPsrHttpMessageBundle(),
            new SecurityBundle(),
            new FriendsOfBehatSymfonyExtensionBundle(),
            new EuLoginApiAuthenticationBundle(),
            new FrameworkBundle(),
        ];
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        foreach (glob(__DIR__ . '/config/packages/*.yaml') as $file) {
            $container->import($file);
        }

        $container->import(__DIR__ . '/config/services.yaml');

        $container->extension(
            'framework',
            [
                'secret' => 'secret',
                'test' => true,
                'router' => ['utf8' => true],
                'secrets' => false,
            ]
        );
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        foreach (glob(__DIR__ . '/config/routes/*.yaml') as $file) {
            $routes->import($file);
        }
    }
}
