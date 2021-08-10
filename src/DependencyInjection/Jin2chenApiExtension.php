<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\DependencyInjection;

use jin2chen\ApiBundle\Response\ExceptionConverter;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Jin2chenApiExtension extends Extension
{
    /**
     * @inheritdoc
     * @psalm-suppress MixedArrayAccess
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'jin2chen.api_bundle.request.request_id_header',
            (string) $config['request']['request_id_header']
        );

        $reference = $container->getDefinition(ExceptionConverter::class);
        $reference->setArgument(1, $config['response']['exception_converters'] ?? []);
    }
}
