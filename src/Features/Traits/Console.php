<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\Assert;

trait Console
{
    use Application;

    private $consoleOutput = "";

    /**
     * @Given I run :command command
     * @Given I run :command in console
     */
    public function runCommand(string $command): void
    {
        $this->consoleOutput = "";
        Artisan::call($command);
        $this->consoleOutput = Artisan::output();
    }

    /**
     * @Given I run :command command with arguments :arguments
     * @Given I run :command command with argument :arguments
     * @Given I run :command command with options :arguments
     * @Given I run :command command with option :arguments
     */
    public function runCommandWithArguments(string $command, string $arguments): void
    {
        $this->runCommand("$command $arguments");
    }

    /**
     * @Then I see :output in console
     * @Then I should see :output in console
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
