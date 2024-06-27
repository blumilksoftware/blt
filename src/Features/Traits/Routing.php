<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait Routing
{
    use HttpRequest;
    use HttpResponse;
    use Session;
    use Authentication;
    //Also translation, waiting for PR to merge.

    /**
     * @Given user is authenticated and requests :url
     * @Given user is authenticated and requests :url using :method method
     */
    public function userIsAuthenticatedAndRequests(string $url, string $method = "GET"): void
    {
        $this->userIsAuthenticatedInSessionAs("test@example.com", "email");
        $this->aUserIsRequesting($url, $method);
        $this->aRequestIsSent();
    }

    /**
     * @Then the user should not be able to access :url
     * @throws BindingResolutionException
     */
    public function userShouldNotBeAbleToAccess(string $url): void
    {
        $this->aUserIsRequesting($url);
        $this->aRequestIsSent();
        $this->aResponseStatusCodeShouldBe(Response::HTTP_FORBIDDEN);
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
     * @Given authenticated user with email :email requests :url
     * @Given authenticated user with email :email requests :url using :method method
     */
    public function authenticatedUserWithEmailRequests(string $email, string $url, string $method = "GET"): void
    {
        $this->userIsAuthenticatedInSessionAs($email, "email");
        $this->aUserIsRequesting($url, $method);
        $this->aRequestIsSent();
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
     * @Then the response status should be :status and the user should be redirected to :url
     */
    public function responseStatusShouldBeAndUserShouldBeRedirectedTo(int $status, string $url): void
    {
        $this->aResponseStatusCodeShouldBe($status);
        $this->authenticatedUserShouldBeRedirectedTo($url);
    }
}
