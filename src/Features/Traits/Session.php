<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Support\ViewErrorBag;
use PHPUnit\Framework\Assert;

trait Session
{
    /**
     * @Then a session flashes errors:
     */
    public function sessionFlashesErrors(TableNode $table): void
    {
        /** @var ViewErrorBag $errors */
        $errors = $this->getContainer()->get("session")->all()["errors"];
        Assert::assertSameSize($table->getHash(), $errors);

        foreach ($table as $row) {
            Assert::assertEquals($row["message"], $errors->get($row["key"])[$row["index"]]);
        }
    }

    /**
     * @Given a session flashes no errors
     */
    public function aSessionFlashesNoErrors(): void
    {
        /** @var ViewErrorBag $errors */
        $errors = $this->getContainer()->get("session")->all()["errors"] ?? [];
        Assert::assertSameSize([], $errors);
    }

    /**
     * @Given the session has the following data:
     */
    public function theSessionHasTheFollowingData(TableNode $table): void
    {
        $session = $this->getContainer()->get("session");

        foreach ($table->getHash() as $row) {
            $session->put($row["key"], $row["value"]);
        }
    }

    /**
     * @Then the session should have the following data:
     */
    public function theSessionShouldHaveTheFollowingData(TableNode $table): void
    {
        $session = $this->getContainer()->get("session");

        foreach ($table->getHash() as $row) {
            Assert::assertEquals($row["value"], $session->get($row["key"]));
        }
    }

    /**
     * @Given the session is revoked
     */
    public function theSessionIsRevoked(): void
    {
        $this->getContainer()->get("session")->invalidate();
    }

    /**
     * @Given the session has no data
     */
    public function theSessionHasNoData(): void
    {
        $session = $this->getContainer()->get("session");
        $session->flush();
    }

    /**
     * @Given the session flashes the following data:
     */
    public function theSessionFlashesTheFollowingData(TableNode $table): void
    {
        $session = $this->getContainer()->get("session");

        foreach ($table->getHash() as $row) {
            $session->flash($row["key"], $row["value"]);
        }
    }

    /**
     * @Then the session should flash the following data:
     */
    public function theSessionShouldFlashTheFollowingData(TableNode $table): void
    {
        $session = $this->getContainer()->get("session");

        foreach ($table->getHash() as $row) {
            Assert::assertEquals($row["value"], $session->get($row["key"]));
        }
    }

    /**
     * @Then the session should have key :key
     */
    public function theSessionShouldHaveKey(string $key): void
    {
        $session = $this->getContainer()->get("session");
        Assert::assertTrue($session->has($key));
    }

    /**
     * @Then the session should not have key :key
     */
    public function theSessionShouldNotHaveKey(string $key): void
    {
        $session = $this->getContainer()->get("session");
        Assert::assertFalse($session->has($key));
    }

    /**
     * @Given the session forgets key :key
     */
    public function theSessionForgetsKey(string $key): void
    {
        $session = $this->getContainer()->get("session");
        $session->forget($key);
    }
}
