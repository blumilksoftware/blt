<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class ArrayHelper
{
    public function toArray(string|array $input, string $separator = " "): array
    {
        if (is_array($input)) {
            return $input;
        }

        if (self::hasArraySyntax($input)) {
            $input = substr($input, 1, -1);
        }

        return explode($separator, $input);
    }

    public function toString(string|array $input, string $separator = " "): string
    {
        if (is_string($input)) {
            return $input;
        }

        return implode($separator, $input);
    }

    public static function hasArraySyntax($input): bool
    {
        return str_starts_with($input, "[") && str_ends_with($input, "]");
    }
}
