<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Illuminate\Support\Str;

class RecognizeClassHelper
{
    public static function recognizeObjectClass(string $objectName): string
    {
        if (strpos($objectName, "\\")) {
            return $objectName;
        }

        $typeNamespaces = config("blt.namespaces.types");
        $objectName = Str::lcfirst($objectName);

        if (array_key_exists($objectName, $typeNamespaces)) {
            return $typeNamespaces[$objectName];
        }

        $type = self::guessType($objectName);
        $objectName = Str::ucfirst($objectName);

        if (array_key_exists($type, $typeNamespaces)) {
            return $typeNamespaces[$type] . $objectName;
        }

        return self::getObjectNamespace(Str::singular($objectName), $type) . $objectName;
    }

    public static function getObjectNamespace(string $objectName, string $type): string
    {
        $type = Str::plural(Str::ucfirst($type));
        $defaultNamespace = config("blt.namespaces.default") ?? "App\\";

        return $defaultNamespace . $type . "\\";
    }

    public static function guessType(string $objectName): string
    {
        $slug = Str::slug($objectName);

        foreach (TypesEnum::cases() as $objectType) {
            $objectTypeName = $objectType->value;

            if (Str::contains($slug, $objectTypeName)) {
                return Str::singular($objectTypeName);
            }
        }

        return TypesEnum::Model->value;
    }
}
