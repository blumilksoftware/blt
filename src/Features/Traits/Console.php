<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\Assert;

trait Console
{
    use Application;

    private string $consoleOutput = "";

    /**
     * @Given I run artisan command :command
     * @Given I run artisan command :command in console
     */
    public function runArtisanCommand(string $command): void
    {
        $this->consoleOutput = "";
        $this->getContainer()->make(Kernel::class)->call($command);
        $this->consoleOutput = $this->getContainer()->make(Kernel::class)->output($command);
    }

    /**
     * @Given I run artisan command :command with arguments :arguments
     * @Given I run artisan command :command with argument :arguments
     * @Given I run artisan command :command with options :arguments
     * @Given I run artisan command :command with option :arguments
     */
    public function runCommandWithArguments(string $command, string $arguments): void
    {
        $this->runArtisanCommand("$command $arguments");
    }

    /**
     * @Given I run artisan command :command with options :options and arguments :arguments
     * @Given I run artisan command :command with option :options and argument :arguments
     * @Given I run artisan command :command with options :options and argument :arguments
     * @Given I run artisan command :command with option :options and arguments :arguments
     */
    public function runCommandWithOptionsAndArguments(string $command, string $options, string $arguments): void
    {
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
