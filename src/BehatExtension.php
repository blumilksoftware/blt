<?php

declare(strict_types=1);

namespace KrzysztofRewak\Larahat;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BehatExtension implements Extension
{
    public function getConfigKey(): string
    {
        return "laravel";
    }

    public function initialize(ExtensionManager $extensionManager): void
    {
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder->children()->scalarNode("env")->defaultValue(".env.behat");
    }

    public function load(ContainerBuilder $container, array $config): void
    {
        $app = require_once $this->getBasePath($container, "/bootstrap/app.php");
        $app->loadEnvironmentFrom($config["env"]);
        $app->make(Laravel::CONSOLE_KERNEL_INTERFACE)->bootstrap();
    }

    public function process(ContainerBuilder $container): void
    {
    }

    protected function getBasePath(ContainerBuilder $container, string $file = ""): string
    {
        return $container->getParameter("paths.base") . $file;
    }
}
