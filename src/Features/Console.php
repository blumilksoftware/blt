<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Console as ConsoleTrait;

class Console implements Context
{
    use ConsoleTrait;
}
