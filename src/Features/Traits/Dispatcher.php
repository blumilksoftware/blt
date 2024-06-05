<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Support\Facades\Bus;

trait Dispatcher
{
    /**
     * @Given Bus is running
     */
    public function runBus(): void
    {
        Bus::fake();
    }

    /**
     * @Then :jobName is dispatched
     * @Then job :jobName is dispatched
     */
    public function jobIsDispatched(string $jobName): void
    {
        $jobClass = $this->recognizeJobClass($jobName);
        $jobClass::dispatch();
        Bus::assertDispatched($jobClass);
    }

    private function recognizeJobClass(string $job): string
    {
        if (strpos($job, "\\")) {
            return $job;
        }

        $job = ucfirst($job);

        return $this->getJobNamespace() . $job;
    }

    private function getJobNamespace(): string
    {
        return "App\\Jobs\\";
    }
}
