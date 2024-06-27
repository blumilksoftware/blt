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

        $objectName = Str::ucfirst(Str::singular($objectName));

        return $this->getObjectNamespace($objectName) . $objectName;
    }

    public function getObjectNamespace(string $objectName): string
    {
        $type = $this->guessType($objectName);
        $typeNamespace = $this->getNamespaceFromConfig($objectName, $type);

        if ($typeNamespace) {
            return $typeNamespace;
        }

        $type = Str::plural(Str::ucfirst($type));
        $defaultNamespace = config("blt.namespaces.default", "App\\");

        return $defaultNamespace . $type . "\\";
    }

    public function guessType(string $objectName): string
    {
        $slug = Str::slug($objectName);

        foreach (TypesEnum::cases() as $objectType) {
            if (Str::contains($slug, $objectType->value)) {
                return Str::singular($objectType->value);
            }
        }

        return "model";
    }

    protected function getNamespaceFromConfig(string $objectName, string $type): ?string
    {
        $typeNamespaces = config("blt.namespaces.types");

        return $typeNamespaces[$objectName] ?? $typeNamespaces[$type] ?? null;
    }
}
