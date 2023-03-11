<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Hooks;

use Blumilk\BLT\Features\Traits\Database;
use Illuminate\Contracts\Container\BindingResolutionException;

trait RefreshDatabaseBeforeScenario
{
    use Database;

    /**
     * @beforeScenario
     * @throws BindingResolutionException
     */
    public function refreshDatabaseBeforeScenario(): void
    {
        $this->refreshDatabase();
    }
}
