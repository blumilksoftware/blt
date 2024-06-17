<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class DotNotationHelper
{
    public static function getValueUsingDotNotation(array $array, string $path)
    {
        $keys = explode(".", $path);

        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return;
            }

            $array = $array[$key];
        }

        return $array;
    }
}
