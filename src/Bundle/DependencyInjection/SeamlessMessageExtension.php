<?php

namespace RusLan\SeamlessMessage\Bundle\DependencyInjection;

use RusLan\SeamlessMessage\Bundle\SeamlessMessageBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SeamlessMessageExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../../resources/config'));
        $loader->load('parameters.yml');
        $loader->load('services.yml');

        $container->getDefinition('rl.seamless_message.loader')
            ->addArgument($config['bots'] ?? [])
        ;
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('twig')) {
            return;
        }

        $container
            ->prependExtensionConfig('twig', [
                'paths' => [
                    __DIR__ . '/../../../resources/templates' => (new \ReflectionClass(SeamlessMessageBundle::class))->getShortName(),
                ]
            ])
        ;
    }
}
