<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

class UserHelper
{
    public function getBy(string $field, string $value): ?object
    {
        $userClass = ContextHelper::getHelper("class")->recognizeObjectClass("User");

        return $userClass::query()->where($field, $value)->first();
    }

    public function getByEmail(string $value): ?object
    {
        $userClass = ContextHelper::getHelper("class")->recognizeObjectClass("User");

        return $userClass::query()->where("email", $value)->first();
    }
}
