<?php

declare(strict_types=1);

namespace Blumilk\BLT\Bootstrapping;

use Blumilk\BLT\LaravelContracts;
use Illuminate\Contracts\Console\Kernel;

class LaravelBootstrapper implements BootstrapperContract
{
    protected string $environmentType = "testing";
    protected string $environmentFile = ".env.behat";
    protected string $basePath = "/application";
    protected array $configOverrides = [];

    public function boot(): void
    {
        $app = $this->getApplication();
        $app->loadEnvironmentFrom($this->environmentFile);

        if (!empty($this->configOverrides)) {
            $app->afterBootstrapping(LaravelContracts::LOAD_CONFIGURATION_CLASS, function ($app): void {
                $app["env"] = $this->environmentType;
                foreach ($this->configOverrides as $key => $value) {
                    $app->make("config")->set($key, $value);
                }
            });
        }

        $app->make($this->getContractToBootstrap())->bootstrap();
    }

    public function setEnvironmentType(string $environmentType): void
    {
        $this->environmentType = $environmentType;
    }

    public function setEnvironmentFile(string $environmentFile): void
    {
        $this->environmentFile = $environmentFile;
    }

    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    public function setConfigOverrides(array $configOverrides): void
    {
        $this->configOverrides = $configOverrides;
    }

    protected function getContractToBootstrap(): string
    {
        return Kernel::class;
    }

    protected function getBootstrapFilePath(): string
    {
        return "{$this->basePath}/bootstrap/app.php";
    }

    protected function getApplication()
    {
        return require $this->getBootstrapFilePath();
    }
}
