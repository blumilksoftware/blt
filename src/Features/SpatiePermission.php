<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features;

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Optional\SpatiePermission as SpatiePermissionTrait;

class SpatiePermission implements Context
{
    use SpatiePermissionTrait;
}
