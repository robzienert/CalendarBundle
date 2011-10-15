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

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')
                            ->children()
                                ->scalarNode('calendar')->isRequired()->end()
                                ->scalarNode('event')->isRequired()->end()
                                ->scalarNode('user')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('form')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('calendar')->isRequired()->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('rizza_calendar.calendar')->end()
                                ->scalarNode('name')->defaultValue('rizza_calendar_calendar')->end()
                            ->end()
                        ->end()
                        ->arrayNode('event')->isRequired()->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('rizza_calendar.event')->end()
                                ->scalarNode('name')->defaultValue('rizza_calendar_event')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

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
                        ->arrayNode('blamer')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('calendar')->cannotBeEmpty()->defaultValue('rizza_calendar.blamer.calendar.security')->end()
                                ->scalarNode('event')->cannotBeEmpty()->defaultValue('rizza_calendar.blamer.event.security')->end()
                            ->end()
                        ->end()
                        ->arrayNode('form_factory')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('calendar')->cannotBeEmpty()->defaultValue('rizza_calendar.form_factory.calendar.default')->end()
                                ->scalarNode('event')->cannotBeEmpty()->defaultValue('rizza_calendar.form_factory.event.default')->end()
                            ->end()
                        ->end()
                        ->arrayNode('manager')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('calendar')->cannotBeEmpty()->defaultValue('rizza_calendar.manager.calendar.default')->end()
                                ->scalarNode('event')->cannotBeEmpty()->defaultValue('rizza_calendar.manager.event.default')->end()
                                ->scalarNode('user')->cannotBeEmpty()->defaultValue('rizza_calendar.manager.user.default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}