<?php

namespace Undelete\BTCEApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;

class UndeleteBTCEApiExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($config['api_key']) && isset($config['api_secret'])) {
            $defenition = new Definition();
            $defenition->setClass($container->getParameter('btce_api.class'));
            $defenition->addArgument($config['api_key']);
            $defenition->addArgument($config['api_secret']);

            $container->addDefinitions(['btce_api' => $defenition]);
        }

    }
}
