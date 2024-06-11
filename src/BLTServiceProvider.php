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
    }
}
