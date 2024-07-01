<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class BooleanHelper
{
    public function toBoolean(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
