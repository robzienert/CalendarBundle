<?php

namespace Rizza\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class RizzaCalendarExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('orm.xml');

        $definition = new Definition('Rizza\CalendarBundle\Twig\Extension\CalendarExtension');
        $definition->addTag('twig.extension');
        $container->setDefinition('rizza_calendar', $definition);
    }
}