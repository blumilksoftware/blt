<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Contracts\Container\Container;

trait Application
{
    protected function getContainer(): Container
    {
        return app();
    }
}
