<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Helpers\ContextHelper;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

trait Authentication
{
    use Eloquent;

    /**
     * @Given user is authenticated in session as :value in :field field
     * @throws BindingResolutionException
     */
    public function userIsAuthenticatedInSessionAs(string $value, string $field): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $user = ContextHelper::getUserHelper()->getBy($field, $value);
        $auth->login($user);
    }

    /**
     * @Given there is no user authenticated in session
     * @throws BindingResolutionException
     */
    public function thereIsNoUserAuthenticatedInSession(): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $auth?->logout();
    }

    /**
     * @Then no user is authenticated in session
     * @throws BindingResolutionException
     */
    public function noUserAuthenticatedInSession(): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        Assert::assertNull($auth->user());
    }

    /**
     * @Then user authenticated in session has :value value in :field field
     * @throws BindingResolutionException
     */
    public function userAuthenticatedInSessionIs(string $value, string $field): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        Assert::assertEquals($value, $auth->user()?->{$field});
    }

    /**
     * @Given there is an authenticated user with email :email
     * @throws BindingResolutionException
     */
    public function thereIsAuthenticatedUserWithEmail(string $email): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $auth->login($this->getUserModel()::query()->where("email", $email)->first());
    }

    /**
     * @Given there are users in the database:
     */
    public function thereAreUsersInTheDatabase(TableNode $table): void
    {
        foreach ($table->getColumnsHash() as $userData) {
            $this->getUserModel()::firstOrCreate($userData);
        }
    }

    /**
     * @Given there is an unauthenticated user
     * @throws BindingResolutionException
     */
    public function thereIsAnUnauthenticatedUser(): void
    {
        $this->thereIsNoUserAuthenticatedInSession();
    }

    /**
     * @Then the authenticated user email should be :email
     * @throws BindingResolutionException
     */
    public function authenticatedUsersEmailShouldBe(string $email): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        Assert::assertEquals($email, $auth->user()->email);
    }

    /**
     * @Then the authenticated user should have the attribute :attribute with value :value
     * @throws BindingResolutionException
     */
    public function authenticatedUserShouldHaveAttribute(string $attribute, $value): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $user = $auth->user();
        Assert::assertEquals($value, $user->{$attribute});
    }

    /**
     * @Given the user is authenticated with attributes:
     */
    public function userIsAuthenticatedWithAttributes(TableNode $table): void
    {
        $attributes = $table->getRowsHash();
        $user = $this->getUserModel()::firstOrCreate($attributes);
        $auth = $this->getContainer()->make(Guard::class);
        $auth->login($user);
    }

    /**
     * @Then the user should be able to logout
     * @throws BindingResolutionException
     */
    public function userShouldBeAbleToLogout(): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $auth->logout();
        Assert::assertNull($auth->user());
    }

    /**
     * @Then the authenticated user should be redirected to :url
     * @throws BindingResolutionException
     */
    public function authenticatedUserShouldBeRedirectedTo(string $url): void
    {
        $response = $this->response;
        Assert::assertTrue(
            $response->isRedirect($url),
            "Authenticated user was not redirected to $url.",
        );
    }

    /**
     * @Then the user with email :email should not be able to access :url
     * @throws BindingResolutionException
     */
    public function userWithEmailShouldNotBeAbleToAccess(string $email, string $url): void
    {
        $auth = $this->getContainer()->make(Guard::class);
        $auth->login($this->getUserModel()::query()->where("email", $email)->first());
        $response = $this->call("GET", $url);
        Assert::assertEquals(Response::HTTP_FORBIDDEN, $response->status());
    }

    /**
     * @return class-string
     */
    protected function getUserModel(): string
    {
        return $this->recognizeModelClass("User");
    }
}
