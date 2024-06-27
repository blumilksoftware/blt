<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Illuminate\Support\Str;

class ClassHelper
{
    public static function recognizeObjectClass(string $objectName): string
    {
        if (strpos($objectName, "\\")) {
            return $objectName;
        }

        $objectName = Str::ucfirst(Str::singular($objectName));

        return self::getObjectNamespace($objectName) . $objectName;
    }

    public static function getObjectNamespace(string $objectName): string
    {
        $type = self::guessType($objectName);
        $typeNamespace = self::getNamespaceFromConfig($objectName, $type);

        if ($typeNamespace) {
            return $typeNamespace;
        }

        $type = Str::plural(Str::ucfirst($type));
        $defaultNamespace = config("blt.namespaces.default", "App\\");

        return $defaultNamespace . $type . "\\";
    }

    public static function guessType(string $objectName): string
    {
        $slug = Str::slug($objectName);

        foreach (TypesEnum::cases() as $objectType) {
            if (Str::contains($slug, $objectType->value)) {
                return Str::singular($objectType->value);
            }
        }

        return "model";
    }

    protected static function getNamespaceFromConfig(string $objectName, string $type): ?string
    {
        $typeNamespaces = config("blt.namespaces.types");

        return $typeNamespaces[$objectName] ?? $typeNamespaces[$type] ?? null;
    }
}
