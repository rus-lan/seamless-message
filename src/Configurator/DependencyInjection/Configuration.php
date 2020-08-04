<?php

namespace RusLan\SeamlessMessage\Configurator\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const name_bundle = 'seamless-message';

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(self::name_bundle);

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root(self::name_bundle);
        }

        $rootNode
            ->children()
                ->arrayNode('bots')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('name')
                                ->info('Имя бота')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('source')
                                ->info('Тип бота')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('default_controller')->end()
                            ->arrayNode('routers')
                                ->useAttributeAsKey('name')
                                ->arrayPrototype()
                                    ->children()
                                        ->scalarNode('action')
                                            ->info('Обработчик события')
                                            ->isRequired()
                                            ->cannotBeEmpty()
                                        ->end()
                                        ->scalarNode('method')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}