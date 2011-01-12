<?php

namespace Bundle\CalendarBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CalendarExtension extends Extension
{
    public function configLoad($config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, __DIR__ . '/../Resources/config');

        if (!isset($config['db_driver'])) {
            throw new \InvalidArgumentException('The db_driver parameter must be defined');
        } else if (!in_array($config['db_driver'], array('orm', 'odm'))) {
            throw new \InvalidArgumentException(sprintf('The db_driver "%s" is not supported (choose either "odm" or "orm")', $config['db_driver']));
        }

        foreach (array($config['db_driver'], 'model', 'controller', 'form') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }

        $loader = new YamlFileLoader($container, __DIR__ . '/../Resources/config');
        $loader->load('routing.yml');
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