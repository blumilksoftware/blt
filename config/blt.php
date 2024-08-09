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
            "role" => "Spatie\Permission\Models\Role",
            "user" => "App\Models\User",
        ],
    ],
    "helpers" => [
        "array" => ArrayHelper::class,
        "boolean" => BooleanHelper::class,
        "class" => ClassHelper::class,
        "nullable" => NullableHelper::class,
        "user" => UserHelper::class,
    ],
    "endpoints" => [
        "home" => "/",
        "login" => "/login",
        "register" => "/register",
        "profile" => "/profile",
        "about" => "/about",
        "contact" => "/contact",
        "help" => "/help",
        "search" => "/search",
        "admin" => "/admin",
        "logout" => "/logout",
    ],
];
