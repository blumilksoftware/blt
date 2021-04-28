<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use PHPUnit\Framework\Assert;

/**
 * Trait Testing
 * @package Blumilk\BLT\Features\Traits
 * @mixin Assert
 */
trait Testing
{
    public function __call(string $name, array $arguments): void
    {
        Assert::$name(...$arguments);
    }
}
