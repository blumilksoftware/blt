<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits\Optional;

use Blumilk\BLT\Features\Traits\Application;
use Blumilk\BLT\Helpers\RecognizeClassHelper;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Assert;

trait SpatiePermission
{
    use Application;

    /**
     * @When user can have role
     * @throws BindingResolutionException
     */
    public function userHasRoles(): void
    {
        $used_traits = class_uses_recursive($this->getContainer()->make(RecognizeClassHelper::recognizeObjectClass("User")));
        Assert::assertTrue(in_array("Spatie\Permission\Traits\HasRoles", $used_traits, true));
    }

    /**
     * @Then assign :role role to :object with :value value in :field field
     */
    public function assignRoleTo(string $role, string $object, string $value, string $field): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->assignRole($role);
    }

    /**
     * @Then give :permission permission to :object with :value value in :field field
     */
    public function givePermissionTo(string $permission, string $value, string $field, string $object): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->givePermissionTo($permission);
    }

    private function getObjectInstance(string $object, string $value, string $field): object
    {
        $objectClass = RecognizeClassHelper::recognizeObjectClass($object);

        return $objectClass::query()->where($field, $value)->first();
    }
}
