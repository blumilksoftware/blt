<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Assert;

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
        $auth->login($this->getUserModel()::query()->where($field, $value)->first());
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
     * @Then the authenticated user's email should be :email
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
     * @return class-string
     */
    protected function getUserModel(): string
    {
        return $this->recognizeModelClass("User");
    }
}
