<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Hooks;

use Blumilk\BLT\Bootstrapping\BootstrapperContract;
use Blumilk\BLT\Bootstrapping\LaravelBootstrapper;

trait RebootAfterFeature
{
    /**
     * @afterFeature
     */
    public static function rebootAfterFeature(): void
    {
        $bootstrapper = static::getRebootAfterFeatureBootstrapper();
        $bootstrapper->boot();
    }

    protected static function getRebootAfterFeatureBootstrapper(): BootstrapperContract
    {
        return new LaravelBootstrapper();
    }
}
