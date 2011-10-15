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

        foreach (array('twig', 'form', 'security', 'blamer') as $base) {
            $loader->load(sprintf('%s.xml', $base));
        }

        $this->loadClass($config, $container);
        $this->loadForm($config, $container);
        $this->loadRouting($config, $container);

        $container->setAlias('rizza_calendar.blamer.calendar', $config['service']['blamer']['calendar']);
        $container->setAlias('rizza_calendar.blamer.event', $config['service']['blamer']['event']);

        $container->setAlias('rizza_calendar.manager.calendar', $config['service']['manager']['calendar']);
        $container->setAlias('rizza_calendar.manager.event', $config['service']['manager']['event']);
        $container->setAlias('rizza_calendar.manager.user', $config['service']['manager']['user']);

        $container->setAlias('rizza_calendar.form_factory.calendar', $config['service']['form_factory']['calendar']);
        $container->setAlias('rizza_calendar.form_factory.event', $config['service']['form_factory']['event']);
    }

    protected function loadClass(array $config, ContainerBuilder $container)
    {
        $container->setParameter('rizza_calendar.model.calendar.class', $config['class']['model']['calendar']);
        $container->setParameter('rizza_calendar.model.event.class', $config['class']['model']['event']);
        $container->setParameter('rizza_calendar.model.user.class', $config['class']['model']['user']);
    }

    protected function loadForm(array $config, ContainerBuilder $container)
    {
        $container->setParameter('rizza_calendar.form.calendar.type', $config['form']['calendar']['type']);
        $container->setParameter('rizza_calendar.form.calendar.name', $config['form']['calendar']['name']);

        $container->setParameter('rizza_calendar.form.event.type', $config['form']['event']['type']);
        $container->setParameter('rizza_calendar.form.event.name', $config['form']['event']['name']);
    }

    protected function loadRouting(array $config, ContainerBuilder $container)
    {
        $container->setParameter('rizza_calendar.routing.calendar.list', $config['routing']['calendar']['list']);
        $container->setParameter('rizza_calendar.routing.calendar.add', $config['routing']['calendar']['add']);
        $container->setParameter('rizza_calendar.routing.calendar.show', $config['routing']['calendar']['show']);
        $container->setParameter('rizza_calendar.routing.calendar.edit', $config['routing']['calendar']['edit']);
        $container->setParameter('rizza_calendar.routing.calendar.delete', $config['routing']['calendar']['delete']);

        $container->setParameter('rizza_calendar.routing.event.list', $config['routing']['event']['list']);
        $container->setParameter('rizza_calendar.routing.event.add', $config['routing']['event']['add']);
        $container->setParameter('rizza_calendar.routing.event.show', $config['routing']['event']['show']);
        $container->setParameter('rizza_calendar.routing.event.edit', $config['routing']['event']['edit']);
    }
}
