<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Helpers\ContextHelper;
use Blumilk\BLT\Helpers\TypesEnum;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Support\Testing\Fakes\BusFake;
use Illuminate\Support\Testing\Fakes\EventFake;
use InvalidArgumentException;

trait Dispatcher
{
    use Application;

    protected BusFake $busFake;
    protected EventFake $eventFake;

    /**
     * @Given bus is running
     * @throws BindingResolutionException
     */
    public function runBus(): void
    {
        $this->busFake = new BusFake($this->getContainer()->make(BusDispatcher::class));
        $this->getContainer()->instance(BusDispatcher::class, $this->busFake);
    }

    /**
     * @Given events are faked
     * @throws BindingResolutionException
     */
    public function fakeEvents(): void
    {
        $this->eventFake = new EventFake($this->getContainer()->make(EventDispatcher::class));
        $this->getContainer()->instance(EventDispatcher::class, $this->eventFake);
    }

    /**
     * @When I dispatch :count :objectName jobs with parameters:
     * @When I dispatch :count :objectName jobs
     * @when I dispatch :objectName job
     * @When I dispatch :count of :objectName events with parameters:
     * @When I dispatch :count of :objectName events
     * @when I dispatch :objectName event
     * @When I dispatch :count of :objectName with parameters:
     * @When I dispatch :count of :objectName
     * @when I dispatch :objectName
     */
    public function dispatchObject(string $objectName, ?TableNode $table = null, int $count = 1): void
    {
        $parameters = [];

        if ($table) {
            foreach ($table as $row) {
                $value = is_numeric($row["value"]) ? (int)$row["value"] : (string)$row["value"];
                $parameters[] = $value;
            }
        }

        $objectClass = ContextHelper::getClassHelper()->recognizeObjectClass($objectName);

        $object = new $objectClass(...$parameters);

        for ($i = 0; $i < $count; $i++) {
            $this->resolveFaker($objectName)->dispatch($object);
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
        $objectClass = ContextHelper::getClassHelper()->recognizeObjectClass($objectName);

        $this->resolveFaker($objectName)->assertDispatched($objectClass, $count);
    }

    protected function resolveFaker(string $objectName): BusFake|EventFake
    {
        $objectType = ContextHelper::getClassHelper()->guessType($objectName);

        return match ($objectType) {
            TypesEnum::Job->value => $this->busFake,
            TypesEnum::Event->value => $this->eventFake,
            default => throw new InvalidArgumentException("Unsupported object type: $objectType"),
        };
    }
}
