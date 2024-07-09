<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits\Optional;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Features\Traits\Application;
use Blumilk\BLT\Helpers\ContextHelper;
use Blumilk\BLT\SpatieLaravelPermissionTraits;
use Illuminate\Contracts\Container\BindingResolutionException;
use PHPUnit\Framework\Assert;

trait SpatiePermission
{
    use Application;

    /**
     * @When :objectName can have role
     * @When user can have role
     * @throws BindingResolutionException
     */
    public function objectCanHaveRoles(string $objectName = "User"): void
    {
        $objectClass = ContextHelper::getClassHelper()->recognizeObjectClass($objectName);
        $usedTraits = class_uses_recursive($this->getContainer()->make($objectClass));
        Assert::assertTrue(in_array(SpatieLaravelPermissionTraits::HAS_ROLES, $usedTraits, true));
    }

    /**
     * @Given :object with :value value in :field field has :role role
     */
    public function assignRoleTo(string $role, string $object, string $value, string $field): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->assignRole($role);
    }

    /**
     * @Given :object with :value value in :field field :permission permission has been revoked
     */
    public function revokePermissionTo(string $permission, string $value, string $field, string $object): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->revokePermissionTo($permission);
    }

    /**
     * @Given :object with :value value in :field field :role role has been removed
     */
    public function revokeRoleTo(string $role, string $object, string $value, string $field): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->removeRole($role);
    }

    /**
     * @Given :object with :value value in :field field has :permission permission
     */
    public function givePermissionTo(string $permission, string $value, string $field, string $object): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        $object->givePermissionTo($permission);
    }

    /**
     * @Then :object with :value value in :field field should have :role role
     */
    public function assertHasRole(string $object, string $field, string $value, string $role): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        Assert::assertTrue($object->hasRole($role));
    }

    /**
     * @Then :object with :value value in :field field should have :permission permission
     */
    public function assertHasPermission(string $object, string $field, string $value, string $permission): void
    {
        $object = $this->getObjectInstance($object, $value, $field);
        Assert::assertTrue($object->hasPermissionTo($permission));
    }

    /**
     * @Then :object with :value value in :field field should have:
     */
    public function assertHas(string $object, string $field, string $value, TableNode $table): void
    {
        $object = $this->getObjectInstance($object, $value, $field);

        foreach ($table as $row) {
            match ($row["key"]) {
                "role" => Assert::assertTrue($object->hasRole($row["value"])),
                "permission" => Assert::assertTrue($object->hasPermissionTo($row["value"])),
            };
        }
    }

    private function getObjectInstance(string $object, string $value, string $field): object
    {
        $objectClass = ContextHelper::getClassHelper()->recognizeObjectClass($object);

        return $objectClass::query()->where($field, $value)->first();
    }
}
