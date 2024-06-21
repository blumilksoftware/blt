<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class DotNotationHelper
{
    public static function getValueUsingDotNotation(array $array, string $path): mixed
    {
        $keys = explode(".", $path);

        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return null;
            }

            $array = $array[$key];
        }

        return $array;
    }
}
