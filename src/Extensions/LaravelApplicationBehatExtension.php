<?php

declare(strict_types=1);

namespace Blumilk\BLT\Extensions;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Blumilk\BLT\Bootstrapping\BootstrapperContract;
use Blumilk\BLT\Bootstrapping\LaravelBootstrapper;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LaravelApplicationBehatExtension implements Extension
{
    protected const CONFIG_KEY = "laravel";

    public function getConfigKey(): string
    {
        return static::CONFIG_KEY;
    }

    public function initialize(ExtensionManager $extensionManager): void
    {
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder->children()->scalarNode("env")->defaultValue(".env.behat");
    }

    public function load(ContainerBuilder $container, array $config = []): void
    {
        $bootstrap = $this->provideBootstrapper();
        $bootstrap->setBasePath($container->getParameter("paths.base"));
        $bootstrap->setEnvironmentFile($config["env"] ?? ".env.behat");
        $bootstrap->boot();
    }

    public function process(ContainerBuilder $container): void
    {
    }

    protected function provideBootstrapper(): BootstrapperContract
    {
        return new LaravelBootstrapper();
    }
}
