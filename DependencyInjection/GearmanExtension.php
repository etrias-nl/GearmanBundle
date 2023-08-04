<?php

namespace Mmoreram\GearmanBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class GearmanExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $configs);

        /**
         * Setting all config elements as DI parameters to inject them
         */
        $container->setParameter(
            'gearman.bundles',
            $configs['bundles']
        );

        $container->setParameter(
            'gearman.resources',
            $configs['resources']
        );

        $container->setParameter(
            'gearman.servers',
            $configs['servers']
        );

        $container->setParameter(
            'gearman.default.settings',
            $configs['defaults']
        );

        $container->setParameter(
            'gearman.default.settings.generate_unique_key',
            $configs['defaults']['generate_unique_key']
        );

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        /**
         * Loading DI definitions
         */
        $loader->load('classes.yml');
        $loader->load('services.yml');
        $loader->load('commands.yml');
        $loader->load('eventDispatchers.yml');
        $loader->load('generators.yml');
        $loader->load('externals.yml');
    }
}
