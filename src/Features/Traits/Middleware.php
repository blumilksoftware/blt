<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\LaravelContracts;
use Closure;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
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
        $this->disableMiddleware(ThrottleRequests::class);
    }

    /**
     * @Given there's CSRF protection middleware disabled
     */
    public function disableCsrfProtection(): void
    {
        $this->disableMiddleware(LaravelContracts::CSRF_PROTECTION_MIDDLEWARE_CLASS);
    }

    /**
     * @Given there is a :middleware middleware enabled
     */
    public function enableMiddleware(string $middleware): void
    {
        $kernel = $this->getContainer()->make(Kernel::class);
        $kernel->pushMiddleware($middleware);
    }

    /**
     * @Then request object should have an UUID in :field field
     */
    public function requestShouldHaveUuidInField(string $field): void
    {
        $request = $this->getContainer()->make(Request::class);
        $uuid = $request->attributes->get($field);

        Assert::assertNotNull($uuid, "The request field $field does not contain a UUID.");
        Assert::assertTrue(
            Str::isUuid($uuid),
            "The request field $field does not contain a valid UUID.",
        );
    }

    /**
     * @Then the middleware :middleware should be applied to the request
     */
    public function middlewareShouldBeAppliedToRequest(string $middleware): void
    {
        $request = $this->getContainer()->make(Request::class);
        Assert::assertTrue($request->attributes->has($middleware));
    }
}
