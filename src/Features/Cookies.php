<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Cookies as CookiesTrait;

class Cookies implements Context
{
    use CookiesTrait;
}
