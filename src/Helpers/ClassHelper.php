<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use Illuminate\Support\Str;

class ClassHelper
{
    public function recognizeObjectClass(string $objectName): string
    {
        if (strpos($objectName, "\\")) {
            return $objectName;
        }

        $objectName = Str::ucfirst($objectName);

        return self::getObjectNamespace(Str::singular($objectName)) . $objectName;
    }

    public function getObjectNamespace(string $objectName): string
    {
        $type = self::guessType($objectName);
        $typeNamespaces = config("blt.namespaces.types");

        if (array_key_exists($objectName, $typeNamespaces)) {
            return $typeNamespaces[$objectName];
        }

        if (array_key_exists($type, $typeNamespaces)) {
            return $typeNamespaces[$type];
        }

        $type = Str::plural(Str::ucfirst($type));
        $defaultNamespace = config("blt.namespaces.default") ?? "App\\";

        return $defaultNamespace . $type . "\\";
    }

    public function guessType(string $objectName): string
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