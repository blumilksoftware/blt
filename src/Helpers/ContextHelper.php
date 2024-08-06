<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class ContextHelper
{
    public static function getArrayHelper(): ArrayHelper
    {
        return new (config("blt.helpers.array") ?? ArrayHelper::class)();
    }

    public static function getBooleanHelper(): BooleanHelper
    {
        return new (config("blt.helpers.boolean") ?? BooleanHelper::class)();
    }

    public static function getClassHelper(): ClassHelper
    {
        return new (config("blt.helpers.class") ?? ClassHelper::class)();
    }

    public static function getNullableHelper(): NullableHelper
    {
        return new (config("blt.helpers.nullable") ?? NullableHelper::class)();
    }

    public static function getUserHelper(): UserHelper
    {
        return new (config("blt.config.user") ?? UserHelper::class)();
    }
}
