<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Assert;

trait Console
{
    use Application;

    private string $consoleOutput = "";

    /**
     * @given I run shell command :command
     * @given I run shell command :command in console
     */
    public function runShellCommand(string $command): void
    {
        $this->consoleOutput = "";
        exec($command, $output);
        $this->consoleOutput = implode("\n", $output);
    }

    /**
     * @Given I run artisan command :command
     * @Given I run artisan command :command in console
     */
    public function runCommand(string $command): void
    {
        $this->consoleOutput = "";
        Artisan::call($command);
        $this->consoleOutput = Artisan::output();
    }

    /**
     * @Given I run artisan command :command with arguments :arguments
     * @Given I run artisan command :command with argument :arguments
     * @Given I run artisan command :command with options :arguments
     * @Given I run artisan command :command with option :arguments
     */
    public function runCommandWithArguments(string $command, string $arguments): void
    {
        $this->runCommand("$command $arguments");
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
