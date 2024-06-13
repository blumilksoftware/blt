<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits\Optional;

use Blumilk\BLT\Features\Traits\Application;
use PHPUnit\Framework\Assert;

trait SpatiePermission
{
    use Application;

    /**
     * @When user can have role
     */
    public function userHasRoles(): void
    {
        $used_traits = class_uses_recursive($this->getContainer()->make('App\Models\User'));
        Assert::assertTrue(in_array("Spatie\Permission\Traits\HasRoles", $used_traits, true));
    }
}
