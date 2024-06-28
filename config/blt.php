<?php

declare(strict_types=1);

use Blumilk\BLT\Helpers\ArrayHelper;
use Blumilk\BLT\Helpers\BooleanHelper;
use Blumilk\BLT\Helpers\ClassHelper;
use Blumilk\BLT\Helpers\UserHelper;
use Blumilk\BLT\Helpers\LaravelRelations;

return [
    "namespaces" => [
        "default" => "App\\",
        "types" => [
            "User" => "App\Models\\",
            "Role" => "Spatie\Permission\Models\\",
        ],
    ],
    "helpers" => [
        "array" => ArrayHelper::class,
        "class" => ClassHelper::class,
        "user" => UserHelper::class,
        "boolean" => BooleanHelper::class,
        "laravelRelations" => LaravelRelations::class
    ],
];
