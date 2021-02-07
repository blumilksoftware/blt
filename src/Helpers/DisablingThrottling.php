<?php

declare(strict_types=1);

namespace KrzysztofRewak\Larahat\Helpers;

use KrzysztofRewak\Larahat\Laravel;

trait DisablingThrottling
{
    /**
     * @beforeScenario
     */
    public function disableThrottling(): void
    {
        app()->instance(
            Laravel::THROTTLING_MIDDLEWARE_CLASS,
            new class {
                public function handle($request, $next)
                {
                    return $next($request);
                }
            }
        );
    }
}
