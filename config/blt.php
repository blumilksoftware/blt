<?php

declare(strict_types=1);
use Blumilk\BLT\Helpers\ArrayHelper;
use Blumilk\BLT\Helpers\ClassHelper;
use Blumilk\BLT\Helpers\ContextHelper;
use Blumilk\BLT\Helpers\NullableHelper;

return [
    "namespaces" => [
        "default" => "App\\",
        "types" => [],
    ],
    "helpers" => [
        "array" => ArrayHelper::class,
        "class" => ClassHelper::class,
        "context" => ContextHelper::class,
        "nullable" => NullableHelper::class,
    ],
];
