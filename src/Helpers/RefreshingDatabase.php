<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Blumilk\BLT\LaravelContracts;

trait RefreshingDatabase
{
    /**
     * @beforeScenario
     */
    public function refreshDatabase(): void
    {
        app(LaravelContracts::CONSOLE_KERNEL_INTERFACE)->call("migrate:fresh");
    }
}
