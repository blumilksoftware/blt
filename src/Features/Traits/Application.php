<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;

trait Application
{
    /**
     * @Given there is :service service mocked with :mock
     * @throws BindingResolutionException
     */
    public function thereIsServiceMocked(string $service, string $mock): void
    {
        $this->getContainer()->instance(
            abstract: $service,
            instance: $this->getContainer()->make($mock),
        );
    }

    /**
     * @Given there are services mocked:
     * @throws BindingResolutionException
     */
    public function thereAreServicesMocked(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->thereIsServiceMocked($row["service"], $row["mock"]);
        }
    }

    protected function getContainer(): Container
    {
        return app();
    }
}
