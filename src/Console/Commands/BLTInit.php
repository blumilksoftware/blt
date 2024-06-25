<?php

declare(strict_types=1);

namespace Blumilk\BLT\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BLTInit extends Command
{
    protected $signature = "blt:init";
    protected $description = "Initialize BLT in your project";

    public function handle(): void
    {
        $this->info("Configuring BLT package...");

        if (!is_dir("features")) {
            $this->initializeBehat();
        }

        if (!file_exists(".env.behat")) {
            $this->copyEnvFile();
        }

        $this->info("Behat configured successfully with BLT");
    }

    protected function initializeBehat(): void
    {
        $process = new Process(["vendor/bin/behat", "--init"]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());
    }

    protected function copyEnvFile(): void
    {
        if (!copy(".env.example", ".env.behat")) {
            $this->error("Failed to copy .env.example to .env.behat");
        }
    }
}
