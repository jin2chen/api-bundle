<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Tests\App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        $contents = require __DIR__ . '/Resources/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('Resources/config/{packages}/*.yaml');
        $container->import('Resources/config/{packages}/' . $this->environment . '/*.yaml');
        $container->import('Resources/config/{services}.yaml');
        $container->import('Resources/config/{services}_' . $this->environment . '.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('Resources/config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('Resources/config/{routes}/*.yaml');
        $routes->import('Resources/config/{routes}.yaml');
    }
}
