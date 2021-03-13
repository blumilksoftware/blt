<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Blumilk\BLT\LaravelContracts;

trait Database
{
    /**
     * @Given there's refreshed database
     */
    public function refreshDatabase(bool $seed = false): void
    {
        $command = "migrate:fresh";
        $command .= $seed ? " --seed" : "";

        app(LaravelContracts::CONSOLE_KERNEL_INTERFACE)->call($command);
    }

    /**
     * @Given there's refreshed and seeded database
     */
    public function refreshDatabaseWithSeeding(bool $seed = false): void
    {
        $this->refreshDatabase(true);
    }

    /**
     * @Given :class seeder has been ran
     */
    public function seederWasRan(string $class): void
    {
        $seeder = new $class();
        $seeder();
    }
}
