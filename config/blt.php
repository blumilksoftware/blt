<?php

declare(strict_types=1);
use Blumilk\BLT\Helpers\ArrayHelper;
use Blumilk\BLT\Helpers\BooleanHelper;
use Blumilk\BLT\Helpers\ClassHelper;
use Blumilk\BLT\Helpers\NullableHelper;
use Blumilk\BLT\Helpers\UserHelper;

return [
    "namespaces" => [
        "default" => "App\\",
        "types" => [
            "User" => "App\Models\User",
        ],
    ],
    "helpers" => [
        "array" => ArrayHelper::class,
        "boolean" => BooleanHelper::class,
        "class" => ClassHelper::class,
        "nullable" => NullableHelper::class,
        "user" => UserHelper::class,
    ],
];
