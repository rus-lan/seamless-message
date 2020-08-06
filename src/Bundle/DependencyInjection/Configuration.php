<?php

namespace RusLan\SeamlessMessage\Bundle\DependencyInjection;

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
        ($treeBuilder = new TreeBuilder(self::name_bundle))
            ->getRootNode()
            ->children()
                ->arrayNode('bots')
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
                                ->arrayPrototype()
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
            ->end()
        ;

        return $treeBuilder;
    }
}
