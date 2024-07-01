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

        return explode($separator, $input);
    }

    public function toString(string|array $input, string $separator = " "): string
    {
        if (is_string($input)) {
            return $input;
        }

        return implode($separator, $input);
    }
}
