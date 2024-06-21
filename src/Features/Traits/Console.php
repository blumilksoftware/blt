<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;

trait Console
{
    use Application;

    protected string $consoleOutput = "";

    /**
     * @Given I run artisan command :command
     * @Given I run artisan command :command in console
     * @throws BindingResolutionException
     */
    public function runArtisanCommand(string $command): void
    {
        $this->consoleOutput = "";
        $this->getContainer()->make(Kernel::class)->call($command);
        $this->consoleOutput = $this->getContainer()->make(Kernel::class)->output();
    }

    /**
     * @Given I run artisan command :command with
     * @throws BindingResolutionException
     */
    public function runCommandWithOptionsAndArguments(string $command, TableNode $table): void
    {
        $options = "";
        $arguments = "";

        foreach ($table->getRows() as $row) {
            if ($row[0] === "option") {
                $options .= " --" . $row[1];
            } elseif ($row[0] === "argument") {
                $arguments .= " " . $row[1];
            } else {
                throw new InvalidArgumentException("Invalid key: $row[0]. Allowed keys are 'option' and 'argument'.");
            }
        }

        $this->runArtisanCommand("$command $options $arguments");
    }

    /**
     * @Then I see :output in console
     * @Then I should see :output in console
     * @Then Console output contains :output
     */
    public function seeInConsole(string $output): void
    {
        Assert::assertStringContainsString($output, $this->consoleOutput);
    }

    /**
     * @Then Console output is not empty
     */
    public function consoleOutputIsNotEmpty(): void
    {
        Assert::assertNotEmpty($this->consoleOutput);
    }

    /**
     * @Then Console output is empty
     */
    public function consoleOutputIsEmpty(): void
    {
        Assert::assertEmpty($this->consoleOutput);
    }
}
