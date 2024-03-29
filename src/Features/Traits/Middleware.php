<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\LaravelContracts;
use Closure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait Middleware
{
    use Application;

    /**
     * @Given there is :middleware middleware disabled
     */
    public function disableMiddleware(string $middleware): void
    {
        $this->getContainer()->instance(
            $middleware,
            new class() {
                public function handle(Request $request, Closure $next): Response
                {
                    return $next($request);
                }
            },
        );
    }

    /**
     * @Given there are middlewares disabled:
     */
    public function disableMiddlewares(TableNode $table): void
    {
        foreach ($table as $middleware) {
            $this->disableMiddleware($middleware["middleware"]);
        }
    }

    /**
     * @Given there's throttling middleware disabled
     */
    public function disableThrottling(): void
    {
        $this->disableMiddleware(LaravelContracts::THROTTLING_MIDDLEWARE_CLASS);
    }

    /**
     * @Given there's CSRF protection middleware disabled
     */
    public function disableCsrfProtection(): void
    {
        $this->disableMiddleware(LaravelContracts::CSRF_PROTECTION_MIDDLEWARE_CLASS);
    }
}
