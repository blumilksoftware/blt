<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\HttpRequest as HttpRequestTrait;

class HttpRequest implements Context
{
    use HttpRequestTrait;
}
