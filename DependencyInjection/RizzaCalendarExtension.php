<?php

namespace Rizza\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

use Rizza\CalendarBundle\DependencyInjection\Configuration;

class RizzaCalendarExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        if (!in_array(strtolower($config['db_driver']), array('orm', 'mongodb'))) {
            throw new \InvalidArgumentException(sprintf('Invalid db driver "%s".', $config['db_driver']));
        }
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        foreach (array('twig') as $base) {
            $loader->load(sprintf('%s.xml', $base));
        }

        $this->loadRouting($config, $container);
    }

    protected function loadRouting(array $config, ContainerBuilder $container)
    {
        $container->setParameter('rizza_calendar.routing.calendar.list', $config['routing']['calendar']['list']);
        $container->setParameter('rizza_calendar.routing.calendar.add', $config['routing']['calendar']['add']);
        $container->setParameter('rizza_calendar.routing.calendar.show', $config['routing']['calendar']['show']);
        $container->setParameter('rizza_calendar.routing.calendar.edit', $config['routing']['calendar']['edit']);
        $container->setParameter('rizza_calendar.routing.calendar.delete', $config['routing']['calendar']['delete']);

        $container->setParameter('rizza_calendar.routing.event.list', $config['routing']['calendar']['list']);
        $container->setParameter('rizza_calendar.routing.event.add', $config['routing']['calendar']['add']);
        $container->setParameter('rizza_calendar.routing.event.show', $config['routing']['calendar']['show']);
        $container->setParameter('rizza_calendar.routing.event.edit', $config['routing']['calendar']['edit']);
    }
}
