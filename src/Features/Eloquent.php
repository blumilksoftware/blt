<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Eloquent as EloquentTrait;

class Eloquent implements Context
{
    use EloquentTrait;
}
