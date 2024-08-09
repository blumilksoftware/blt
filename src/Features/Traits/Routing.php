<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Routing\Router;
use PHPUnit\Framework\Assert;

trait Routing
{
    use HttpRequest;
    use HttpResponse;
    use Session;
    use Application;

    /**
     * @Given user is accessing route named :routeName
     */
    public function userIsAccessingRouteNamed(string $routeName): void
    {
        $router = $this->getContainer()->make(Registrar::class);
        $route = $router->getRoutes()->getByName($routeName);
        $uri = $route ? $route->uri() : "/" . $routeName;
        $uri = config("blt.endpoints.$routeName", $uri);

        Assert::assertNotNull($uri, "Route $routeName does not exist.");
        $this->aUserIsRequesting($uri);
        $this->aRequestIsSent();
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
        $expectedUri = $router->url()->route($routeName);
        $actualUri = $this->response->headers->get("Location");
        Assert::assertEquals($expectedUri, $actualUri, "User was not redirected to the route $routeName.");
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

    /**
     * @Then the route :routeName should exist with the following methods:
     */
    public function routeShouldExistWithMethods(string $routeName, TableNode $methodsTable): void
    {
        $router = $this->getContainer()->make(Router::class);
        $route = $router->getRoutes()->getByName($routeName);
        Assert::assertNotNull($route, "Route $routeName does not exist.");

        $supportedMethods = $route->methods();

        foreach ($methodsTable as $row) {
            $method = strtoupper($row["method"]);
            Assert::assertContains($method, $supportedMethods, "Route $routeName does not support the method $method.");
        }
    }
}
