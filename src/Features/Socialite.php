<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Optional\Socialite as SocialiteTrait;

class Socialite implements Context
{
    use SocialiteTrait;
}
