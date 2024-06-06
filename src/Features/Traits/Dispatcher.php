<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Blumilk\BLT\Helpers\ArrayHelper;
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
     * @When I dispatch :count :jobName jobs with parameters: :parameters
     * @When I dispatch :count :jobName jobs
     * @when I dispatch :jobName job
     */
    public function dispatchJobs(string $jobName, int $count = 1, string|array $parameters = []): void
    {
        $parameters = ArrayHelper::toArray($parameters);

        $jobClass = $this->recognizeJobClass($jobName);
        $job = new $jobClass(...$parameters);

        for ($i = 0; $i < $count; $i++) {
            Bus::dispatch($job);
        }
    }

    /**
     * @Then I should see :jobName job was dispatched
     * @Then I should see :count :jobName jobs were dispatched
     */
    public function assertJobsDispatched(string $jobName, int $count = 1): void
    {
        $jobClass = $this->recognizeJobClass($jobName);
        Bus::assertDispatched($jobClass, $count);
    }

    private function recognizeJobClass(string $jobName): string
    {
        if (strpos($jobName, "\\")) {
            return $jobName;
        }

        $jobName = ucfirst($jobName);

        return $this->getJobNamespace() . $jobName;
    }

    private function getJobNamespace(): string
    {
        return "App\\Jobs\\";
    }
}
