<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits\Optional;

use Blumilk\BLT\Features\Traits\Application;

trait OpenApiToolbox
{
    use Application;

    /**
     * @Then OpenApi documentation is valid
     */
    public function apiEndpointsAreConsistentWithOpenApiDocumentation(): void
    {
        $this->getContainer()->call("openapi:validate");
        //    TODO: add console assert output from console PR
    }
}
