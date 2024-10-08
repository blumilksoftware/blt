<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Routing as RoutingTrait;

class Routing implements Context
{
    use RoutingTrait;
}
