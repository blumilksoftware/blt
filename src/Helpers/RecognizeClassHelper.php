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

        $objectName = Str::ucfirst(Str::singular($objectName));

        return self::getObjectNamespace($objectName) . $objectName;
    }

    public static function getObjectNamespace(string $objectName): string
    {
        $type = Str::plural(self::guessType($objectName));

        return "App\\$type\\";
    }

    public static function guessType(string $objectName): string
    {
        foreach (TypesEnum::cases() as $objectType) {
            $slug = Str::slug($objectName);
            $objectTypeName = $objectType->value;

            if (Str::contains($slug, $objectTypeName)) {
                return Str::ucfirst(Str::singular($objectTypeName));
            }
        }

        return $objectName;
    }
}
