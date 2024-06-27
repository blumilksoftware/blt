<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Illuminate\Support\Str;

class ContextHelper
{
    public static function get(
        string $helper,
    ) {
        return config("blt.helpers.$helper") ?? "Blumilk\BLT\Helpers\\" . Str::ucfirst($helper) . "Helper";
    }
}