<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Dispatcher as DispatcherTrait;

class Dispatcher implements Context
{
    use DispatcherTrait;
}
