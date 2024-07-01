<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Notification as NotificationTrait;

class Notification implements Context
{
    use NotificationTrait;
}
