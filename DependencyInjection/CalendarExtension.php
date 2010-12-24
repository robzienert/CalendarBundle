<?php

namespace Bundle\CalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;

class CalendarExtension extends Extension
{
    public function configLoad($config, ContainerBuilder $container)
    {
        if (!$container->hasDefinition('calendar')) {
            $loader = new XmlFileLoader($container, __DIR__ . '/../Resources/config');
            $loader->load('expression.xml');
        }
    }

    public function getXsdValidationBasePath()
    {
        return __DIR__ . '/../Resources/config/schema';
    }

    public function getNamespace()
    {
        return __DIR__ . '/../Resources/config/schema';
    }

    public function getAlias()
    {
        return 'calendar';
    }
}