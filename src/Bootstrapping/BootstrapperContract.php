<?php

declare(strict_types=1);

namespace Blumilk\BLT\Bootstrapping;

interface BootstrapperContract
{
    public function boot(): void;

    public function setEnvironmentType(string $environmentType): void;

    public function setEnvironmentFile(string $environmentFile): void;

    public function setBasePath(string $basePath): void;

    public function setConfigOverrides(array $configOverrides): void;
}
