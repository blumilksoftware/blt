<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use PHPUnit\Framework\Assert;

trait Console
{
    use Application;

    protected string $consoleOutput = "";
    protected int $consoleCode;

    /**
     * @Given I run artisan command :command
     * @Given I run artisan command :command in console
     * @throws BindingResolutionException
     */
    public function runArtisanCommand(string $command): void
    {
        $this->consoleOutput = "";
        $this->consoleCode = $this->getContainer()->make(Kernel::class)->call($command);
        $this->consoleOutput = $this->getContainer()->make(Kernel::class)->output();
    }

    /**
     * @Given I run artisan command :command with:
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
     * @Then console output contains :output
     * @Then console output should contain :output
     */
    public function seeInConsole(string $output): void
    {
        Assert::assertStringContainsString($output, $this->consoleOutput);
    }

    /**
     * @Then console output is not empty
     */
    public function consoleOutputIsNotEmpty(): void
    {
        Assert::assertNotEmpty($this->consoleOutput);
    }

    /**
     * @Then console output is empty
     */
    public function consoleOutputIsEmpty(): void
    {
        Assert::assertEmpty($this->consoleOutput);
    }

    /**
     * @Then console exit code is :code
     * @Then console exit code should be :code
     */
    public function consoleExitCodeIs(int $code): void
    {
        Assert::assertEquals($this->consoleCode, $code);
    }
}
