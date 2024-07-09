<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class DocumentationTest extends TestCase
{
    public function testIfDocumentationContainsAllPublicFunctions(): void
    {
        $functions = $this->getPublicFunctions();

        foreach ($functions as $class => $methods) {
            $trait = explode("\\", $class );
            $fileName = Str::slug(end($trait)) . ".html";
            $filePath = "docs/elements/$fileName";

            if (!file_exists($filePath)) {
                if (str_ends_with($filePath, "httprequest.html")) {
                    $filePath = str_replace("httprequest.html", "http.html", $filePath);
                } elseif (str_ends_with($filePath, "httpresponse.html")) {
                    $filePath = str_replace("httpresponse.html", "http.html", $filePath);
                }

                if (str_ends_with($filePath, "spatiepermission.html")) {
                    $filePath = str_replace("spatiepermission.html", "spatie-permission.html", $filePath);
                }

                if (!file_exists($filePath)) {
                    $this->fail("Documentation file $filePath does not exist.");
                }
            }

            $fileContent = file_get_contents($filePath);

            if ($fileContent === false) {
                $this->fail("Unable to read the file $filePath.");
            }

            foreach ($methods as $method) {
                $containsFunction = strpos($fileContent, $method) !== false;
                $this->assertTrue($containsFunction, "Function $method is not documented in $filePath.");
            }
        }
    }

    public function getClasses()
    {
        $classes = include "vendor/composer/autoload_classmap.php";
        $bltTraits = [];

        foreach (array_keys($classes) as $class) {
            if (str_contains($class, "Blumilk\BLT\Features\Traits")) {
                $bltTraits[] = $class;
            }
        }

        return $bltTraits;
    }

    public function getPublicFunctions()
    {
        $traitClasses = $this->getClasses();
        $publicFunctions = [];

        foreach ($traitClasses as $traitClass) {
            $traitReflection = new ReflectionClass($traitClass);
            $publicMethods = $traitReflection->getMethods(ReflectionMethod::IS_PUBLIC);
            $includedTraitNames = $traitReflection->getTraitNames();
            $includedTraitPublicMethods = [];

            foreach ($includedTraitNames as $includedTraitName) {
                $includedTraitPublicMethods = array_merge(
                    (new ReflectionClass($includedTraitName))->getMethods(ReflectionMethod::IS_PUBLIC),
                    $includedTraitPublicMethods,
                );
            }

            $includedTraitMethodNames = [];

            foreach ($includedTraitPublicMethods as $includedTraitMethod) {
                $includedTraitMethodNames[] = $includedTraitMethod->getName();
            }

            foreach ($publicMethods as $publicMethod) {
                if (!in_array($publicMethod->getName(), $includedTraitMethodNames, true)) {
                    $publicFunctions[$traitClass][] = $publicMethod->getName();
                }
            }
        }

        return $publicFunctions;
    }
}
