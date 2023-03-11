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
}
