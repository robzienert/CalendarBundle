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

        foreach (array('twig', 'form', 'security', 'blamer', 'creator') as $base) {
            $loader->load(sprintf('%s.xml', $base));
        }

        $this->loadClass($config, $container);
        $this->loadForm($config, $container);
        $this->loadRouting($config, $container);

        $container->setAlias('rizza_calendar.creator.calendar', $config['service']['creator']['calendar']);
        $container->setAlias('rizza_calendar.creator.event', $config['service']['creator']['event']);
        $container->setAlias('rizza_calendar.creator.attendee', $config['service']['creator']['attendee']);

        $container->setAlias('rizza_calendar.blamer.calendar', $config['service']['blamer']['calendar']);
        $container->setAlias('rizza_calendar.blamer.event', $config['service']['blamer']['event']);
        $container->setAlias('rizza_calendar.blamer.attendee', $config['service']['blamer']['attendee']);

        $container->setAlias('rizza_calendar.manager.calendar', $config['service']['manager']['calendar']);
        $container->setAlias('rizza_calendar.manager.event', $config['service']['manager']['event']);
        $container->setAlias('rizza_calendar.manager.user', $config['service']['manager']['user']);
        $container->setAlias('rizza_calendar.manager.attendee', $config['service']['manager']['attendee']);

        $container->setAlias('rizza_calendar.form_factory.calendar', $config['service']['form_factory']['calendar']);
        $container->setAlias('rizza_calendar.form_factory.event', $config['service']['form_factory']['event']);
        $container->setAlias('rizza_calendar.form_factory.attendee', $config['service']['form_factory']['attendee']);
    }

    protected function loadClass(array $config, ContainerBuilder $container)
    {
        $container->setParameter('rizza_calendar.model.calendar.class', $config['class']['model']['calendar']);
        $container->setParameter('rizza_calendar.model.event.class', $config['class']['model']['event']);
        $container->setParameter('rizza_calendar.model.user.class', $config['class']['model']['user']);
        $container->setParameter('rizza_calendar.model.attendee.class', $config['class']['model']['attendee']);
    }

    protected function loadForm(array $config, ContainerBuilder $container)
    {
        foreach (array('calendar', 'event', 'attendee') as $base) {
            $container->setParameter(sprintf('rizza_calendar.form.%s.type', $base), $config['form'][$base]['type']);
            $container->setParameter(sprintf('rizza_calendar.form.%s.name', $base), $config['form'][$base]['name']);
        }
    }

    protected function loadRouting(array $config, ContainerBuilder $container)
    {
        foreach (array('calendar', 'event', 'attendee') as $controller) {
            foreach (array('list', 'add', 'show', 'edit', 'delete') as $action) {
                $container->setParameter(sprintf('rizza_calendar.routing.%s.%s', $controller, $action), $config['routing'][$controller][$action]);
            }
        }
    }
}
