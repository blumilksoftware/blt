<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\LaravelContracts;
use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Middleware implements Context
{
    /**
     * @Given there's :middleware middleware disabled
     */
    public function disableMiddleware(string $middleware): void
    {
        app()->instance(
            $middleware,
            new class() {
                public function handle(Request $request, Closure $next): Response
                {
                    return $next($request);
                }
            }
        );
    }

    /**
     * @Given there's throttling middleware disabled
     */
    public function disableThrottling(): void
    {
        $this->disableMiddleware(LaravelContracts::THROTTLING_MIDDLEWARE_CLASS);
    }
}
