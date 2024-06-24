<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class GetUserHelper
{
    public static function getUser(string $field, string $value): object
    {
        $userClass = RecognizeClassHelper::recognizeObjectClass("User");

        return $userClass::query()->where($field, $value)->first();
    }
}
