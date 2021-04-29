<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Testing as TestingTrait;

class Testing implements Context
{
    use TestingTrait;
}
