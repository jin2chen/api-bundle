<?php

namespace jin2chen\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     * @psalm-suppress all
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('jin2chen_api');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('request')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('request_id_header')
                        ->defaultValue('X-Request-id')
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}