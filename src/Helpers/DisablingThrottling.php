<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Blumilk\BLT\LaravelContracts;
use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait DisablingThrottling
{
    /**
     * @beforeScenario
     */
    public function disableThrottling(): void
    {
        app()->instance(
            LaravelContracts::THROTTLING_MIDDLEWARE_CLASS,
            new class() {
                public function handle(Request $request, Closure $next): Response
                {
                    return $next($request);
                }
            }
        );
    }
}
