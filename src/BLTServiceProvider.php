<?php

declare(strict_types=1);

namespace Blumilk\BLT;

use Blumilk\BLT\Console\Commands\BLTInit;
use Illuminate\Support\ServiceProvider;

class BLTServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            BLTInit::class,
        ]);
        $this->publishes([
            __DIR__ . "/../config/blt.php" => config_path("blt.php"),
        ], "config");
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/blt.php", "blt");
    }
}
