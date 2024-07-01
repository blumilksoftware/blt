<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class UserHelper
{
    public static function getBy(string $field, string $value): ?object
    {
        $userClass = RecognizeClassHelper::recognizeObjectClass("User");

        return $userClass::query()->where($field, $value)->first();
    }

    public static function getByEmail(string $value): ?object
    {
        $userClass = RecognizeClassHelper::recognizeObjectClass("User");

        return $userClass::query()->where("email", $value)->first();
    }
}
