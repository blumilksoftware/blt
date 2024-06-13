<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\HttpResponse as HttpResponseTrait;

class Response implements Context
{
    use HttpResponseTrait;
}
