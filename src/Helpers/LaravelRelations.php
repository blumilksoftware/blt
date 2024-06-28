<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use PHPUnit\Framework\Assert;

class LaravelRelations
{
    public function assertRelation($instance, string $relation, string $relationType): void
    {
        $related = $instance->{$relation}();
        Assert::assertInstanceOf(
            $relationType,
            $related,
            "The relation $relation is not of type $relationType.",
        );
    }
}
