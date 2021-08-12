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
        $contents = require __DIR__ . '/Resource/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('Resource/config/{packages}/*.yaml');
        $container->import('Resource/config/{packages}/' . $this->environment . '/*.yaml');
        $container->import('Resource/config/{services}.yaml');
        $container->import('Resource/config/{services}_' . $this->environment . '.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('Resource/config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('Resource/config/{routes}/*.yaml');
        $routes->import('Resource/config/{routes}.yaml');
    }
}
