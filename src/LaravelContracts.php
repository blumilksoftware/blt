<?php

declare(strict_types=1);

namespace Blumilk\BLT;

class LaravelContracts
{
    public const CSRF_PROTECTION_MIDDLEWARE_CLASS = "Illuminate\Foundation\Http\Middleware\VerifyCsrfToken";
    public const LOAD_CONFIGURATION_CLASS = "Illuminate\Foundation\Bootstrap\LoadConfiguration";
}
