<?php

declare(strict_types=1);

namespace KrzysztofRewak\Larahat\Helpers;

use KrzysztofRewak\Larahat\Laravel;

trait RefreshingDatabase
{
    /**
     * @beforeScenario
     */
    public function refreshDatabase(): void
    {
        app(Laravel::CONSOLE_KERNEL_INTERFACE)->call("migrate:fresh");
    }
}
