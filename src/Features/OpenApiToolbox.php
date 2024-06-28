<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Optional\OpenApiToolbox as OpenApiToolboxTrait;

class OpenApiToolbox implements Context
{
    use OpenApiToolboxTrait;
}
