<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Routing\Router;
use PHPUnit\Framework\Assert;

trait Routing
{
    use HttpRequest;
    use HttpResponse;
    use Session;

    /**
     * @Given user is accessing route named :routeName
     */
    public function userIsAccessingRouteNamed(string $routeName, Router $router): void
    {
        $url = $router->has($routeName) ? $router->url()->route($routeName) : null;
        Assert::assertNotNull($url, "Route $routeName does not exist.");
        $this->aUserIsRequesting($url);
        $this->aRequestIsSent();
    }

    /**
     * @Given user is accessing the home route
     */
    public function userIsAccessingHomeRoute(Router $router): void
    {
        $this->userIsAccessingRouteNamed("home", $router);
    }

    /**
     * @Then the route :routeName should exist
     */
    public function routeShouldExist(string $routeName, Router $router): void
    {
        $routeExists = $router->has($routeName);
        Assert::assertTrue($routeExists, "Route $routeName does not exist.");
    }

    /**
     * @Then the user should be redirected to the route named :routeName
     */
    public function userShouldBeRedirectedToRouteNamed(string $routeName, Router $router): void
    {
        $expectedUrl = $router->url()->route($routeName);
        $actualUrl = $this->response->headers->get("Location");
        Assert::assertEquals($expectedUrl, $actualUrl, "User was not redirected to the route $routeName.");
    }

    /**
     * @Then the response should contain JSON with key :key and value :value
     */
    public function responseShouldContainJsonWithKeyAndValue(string $key, string $value): void
    {
        $json = json_decode($this->response->getContent(), true);
        Assert::assertEquals($value, data_get($json, $key));
    }

    /**
     * @Then the response should have status :status and contain JSON with key :key and value :value
     */
    public function responseShouldHaveStatusAndContainJson(int $status, string $key, string $value): void
    {
        $this->aResponseStatusCodeShouldBe($status);
        $this->responseShouldContainJsonWithKeyAndValue($key, $value);
    }
}
