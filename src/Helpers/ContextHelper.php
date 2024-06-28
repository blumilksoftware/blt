<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Illuminate\Support\Str;

class ContextHelper
{
    public static function getHelper(string $helper)
    {
        $helperClass = match($helper) {
            "array" => config("blt.helpers.array"),
            "boolean" => config("blt.helpers.boolean"),
            "class" => config("blt.helpers.class"),
            "context" => config("blt.helpers.context"),
            "nullable" => config("blt.helpers.nullable"),
        };

        if (!$helperClass) {
            $helperClass = "Blumilk\BLT\Helpers\\" . Str::studly($helper) . "Helper";
        }

        if (!class_exists($helperClass)) {
            throw new \Exception("Helper class $helperClass does not exist.");
        }

        return new $helperClass();
    }
}
