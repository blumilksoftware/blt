<?php

declare(strict_types=1);

namespace Blumilk\BLT;

use Blumilk\BLT\Console\Commands\BltInit;
use Illuminate\Support\ServiceProvider;

class BltServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            BltInit::class,
        ]);
    }
}
