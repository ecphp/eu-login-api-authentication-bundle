<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/ecphp
 */

declare(strict_types=1);

namespace EcPhp\EuLoginApiAuthenticationBundle\DependencyInjection;

use Override;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    #[Override]
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('eu_login_api_authentication');

        /** @var \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
            ->scalarNode('client_id')->isRequired()->end()
            ->scalarNode('client_secret')->isRequired()->end()
            ->scalarNode('environment')
            ->cannotBeEmpty()
            ->isRequired()
            ->defaultValue('production')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
