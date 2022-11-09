<?php

namespace PaneeDesign\DiscriminatorMapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ped_discriminator_map');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('ped_discriminator_map');
        }

        $rootNode
            ->children()
                ->arrayNode('maps')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                        ->useAttributeAsKey('name')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('entity')
                            ->end()
                            ->arrayNode('children')
                                ->useAttributeAsKey('name')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
