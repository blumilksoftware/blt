<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\LaravelContracts;

class Database implements Context
{
    /**
     * @Given there's refreshed database
     */
    public function refreshDatabase(): void
    {
        app(LaravelContracts::CONSOLE_KERNEL_INTERFACE)->call("migrate:fresh");
    }
}
