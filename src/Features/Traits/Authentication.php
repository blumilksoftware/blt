<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

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
     * @return class-string
     */
    protected function getUserModel(): string
    {
        return $this->recognizeModelClass("User");
    }
}
