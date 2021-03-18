<?php

declare(strict_types=1);

namespace Blumilk\BLT;

class LaravelContracts
{
    public const CONSOLE_KERNEL_INTERFACE = "Illuminate\Contracts\Console\Kernel";
    public const THROTTLING_MIDDLEWARE_CLASS = "Illuminate\Routing\Middleware\ThrottleRequests";
    public const LOAD_CONFIGURATION_CLASS = "Illuminate\Foundation\Bootstrap\LoadConfiguration";
}
