<?php

declare(strict_types=1);

namespace Blumilk\BLT;

use Illuminate\Routing\Middleware\ThrottleRequests;

class LaravelContracts
{
    public const THROTTLING_MIDDLEWARE_CLASS = ThrottleRequests::class;
    public const CSRF_PROTECTION_MIDDLEWARE_CLASS = "Illuminate\Foundation\Http\Middleware\VerifyCsrfToken";
    public const LOAD_CONFIGURATION_CLASS = "Illuminate\Foundation\Bootstrap\LoadConfiguration";
}
