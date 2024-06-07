<?php

declare(strict_types=1);

namespace Blumilk\BLT\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class BltInit extends Command
{
    protected $signature = "blt:init";
    protected $description = "Initialize BLT in your project";

    public function handle(): void
    {
        $featureContextPath = "features/bootstrap/FeatureContext.php";
        $this->info("Configuring BLT package...");

        if (!is_dir("features")) {
            shell_exec("vendor/bin/behat --init");

            if (file_exists($featureContextPath)) {
                try {
                    $this->insertAfterLine($featureContextPath, 5, "use Blumilk\BLT\Bootstrapping\LaravelBootstrapper;");
                    $this->insertAfterLine($featureContextPath, 6, "use Blumilk\BLT\Features\Toolbox;");
                    $this->replaceLine($featureContextPath, 12, "class FeatureContext extends Toolbox implements Context");
                    $this->insertAfterLine($featureContextPath, 22, "      \$bootstrapper = new LaravelBootstrapper();\n      \$bootstrapper->boot();");
                } catch (Exception $e) {
                    $this->error("Error configuring FeatureContext: " . $e->getMessage());

                    return;
                }
            }
        }

        if (!file_exists(".env.behat")) {
            if (!copy(".env.example", ".env.behat")) {
                $this->error("Failed to copy .env.example to .env.behat");

                return;
            }
        }

        $this->info("Behat configured successfully with BLT");
    }

    protected function insertAfterLine(string $filePath, int $lineNumber, string $text): void
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            throw new Exception("Failed to read file: $filePath");
        }
        array_splice($lines, $lineNumber, 0, $text);

        if (file_put_contents($filePath, implode(PHP_EOL, $lines)) === false) {
            throw new Exception("Failed to write to file: $filePath");
        }
    }

    protected function replaceLine(string $filePath, int $lineNumber, string $text): void
    {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES);

        if ($lines === false) {
            throw new Exception("Failed to read file: $filePath");
        }

        if (!isset($lines[$lineNumber - 1])) {
            throw new Exception("Line number $lineNumber does not exist in file: $filePath");
        }
        $lines[$lineNumber - 1] = $text;

        if (file_put_contents($filePath, implode(PHP_EOL, $lines)) === false) {
            throw new Exception("Failed to write to file: $filePath");
        }
    }
}
