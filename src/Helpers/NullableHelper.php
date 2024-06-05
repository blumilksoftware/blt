<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class NullableHelper
{
    public static function behatNull(string $nullable): ?string
    {
        return $nullable !== "null" ? $nullable : null;
    }
}