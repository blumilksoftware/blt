<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Container\BindingResolutionException;

trait Database
{
    use Application;

    /**
     * @Given there's refreshed database
     * @throws BindingResolutionException
     */
    public function refreshDatabase(bool $seed = false): void
    {
        $command = "migrate:fresh";
        $command .= $seed ? " --seed" : "";

        $this->getContainer()->make(Kernel::class)->call($command);
    }

    /**
     * @Given there's refreshed and seeded database
     * @throws BindingResolutionException
     */
    public function refreshDatabaseWithSeeding(): void
    {
        $this->refreshDatabase(true);
    }

    /**
     * @Given :class seeder has been run
     */
    public function seederWasRan(string $class): void
    {
        $seeder = new $class();
        $seeder();
    }
}
