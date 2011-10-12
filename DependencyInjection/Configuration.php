<?php

namespace Rizza\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Richard Shank <develop@zestic.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rizza_calendar');
        $rootNode
            ->children()
                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()

                ->arrayNode('routing')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('calendar')->isRequired()->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('rizza_calendar_list')->end()
                                ->scalarNode('add')->defaultValue('rizza_calendar_add')->end()
                                ->scalarNode('show')->defaultValue('rizza_calendar_show')->end()
                                ->scalarNode('edit')->defaultValue('rizza_calendar_edit')->end()
                                ->scalarNode('delete')->defaultValue('rizza_calendar_delete')->end()
                            ->end()
                        ->end()
                        ->arrayNode('event')->isRequired()->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('list')->defaultValue('rizza_calendar_event_list')->end()
                                ->scalarNode('add')->defaultValue('rizza_calendar_event_add')->end()
                                ->scalarNode('show')->defaultValue('rizza_calendar_event_show')->end()
                                ->scalarNode('edit')->defaultValue('rizza_calendar_event_edit')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('service')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('manager')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('calendar')->cannotBeEmpty()->defaultValue('rizza_calendar.manager.calendar.default')->end()
                                ->scalarNode('event')->cannotBeEmpty()->defaultValue('rizza_calendar.manager.event.default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}