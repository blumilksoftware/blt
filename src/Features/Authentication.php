<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Authentication as AuthenticationTrait;

class Authentication implements Context
{
    use AuthenticationTrait;
}
