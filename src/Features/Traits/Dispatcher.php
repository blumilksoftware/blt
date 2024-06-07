<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Blumilk\BLT\Helpers\ArrayHelper;
use Blumilk\BLT\Helpers\RecognizeClassHelper;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;

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
     * @Given events are faked
     */
    public function fakeEvents(): void
    {
        Event::fake();
    }

    /**
     * @When I dispatch :count :objectName jobs with parameters: :parameters
     * @When I dispatch :count :objectName jobs
     * @when I dispatch :objectName job
     * @When I dispatch :count of :objectName events with parameters: :parameters
     * @When I dispatch :count of :objectName events
     * @when I dispatch :objectName event
     * @When I dispatch :count of :objectName with parameters: :parameters
     * @When I dispatch :count of :objectName
     * @when I dispatch :objectName
     */
    public function dispatchJobs(string $objectName, int $count = 1, string|array $parameters = []): void
    {
        $parameters = ArrayHelper::toArray($parameters);

        $objectClass = RecognizeClassHelper::recognizeObjectClass($objectName);
        $objectType = RecognizeClassHelper::guessType($objectName);

        if ($objectType === "Job") {
            $objectType = "Bus";
        }
        $object = new $objectClass(...$parameters);

        for ($i = 0; $i < $count; $i++) {
            $objectType::dispatch($object);
        }
    }

    /**
     * @Then I should see :objectName event was dispatched
     * @Then I should see :count of :objectName events were dispatched
     * @Then I should see :objectName job was dispatched
     * @Then I should see :count of :objectName jobs were dispatched
     * @Then I should see :objectName was dispatched
     * @Then I should see :count of :objectName were dispatched
     */
    public function assertDispatched(string $objectName, int $count = 1): void
    {
        $objectType = RecognizeClassHelper::guessType($objectName);
        $objectClass = RecognizeClassHelper::recognizeObjectClass($objectName);

        if ($objectType === "Job") {
            $objectType = "Bus";
        }
        $objectType::assertDispatched($objectClass, $count);
    }
}
