<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Environment as EnvironmentTrait;

class Environment implements Context
{
    use EnvironmentTrait;
}
