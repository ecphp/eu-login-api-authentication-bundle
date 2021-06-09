<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EuLoginApiAuthenticationExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Load API GW Authentication configuration.
        $container->setParameter('eu_login_api_authentication', $config);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.php');
    }

    public function prepend(ContainerBuilder $container)
    {
        // Configure the symfony/security bundle
        // Add the API Gateway user provider.
        $container
            ->loadFromExtension(
                'security',
                [
                    'providers' => [
                        'eu_login_api_authentication' => [
                            'id' => 'eu_login_api_authentication.user_provider',
                        ],
                    ],
                ]
            );
    }
}
