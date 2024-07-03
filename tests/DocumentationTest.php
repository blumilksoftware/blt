<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class DocumentationTest extends TestCase
{
    public function testIfDocumentationContainsAllPublicFunctions(): void
    {
        exec("php FileCrawler.php");

        // Read the phrases.json file
        $jsonContent = file_get_contents("phrases.json");
        $traits = json_decode($jsonContent, true);

        foreach ($traits as $trait => $functions) {
            $fileName = Str::slug($trait) . ".html";
            $filePath = "docs/elements/$fileName";

            if (!file_exists($filePath)) {
                if (str_ends_with($filePath, "httprequest.html")) {
                    $filePath = str_replace("httprequest.html", "http.html", $filePath);
                } elseif (str_ends_with($filePath, "httpresponse.html")) {
                    $filePath = str_replace("httpresponse.html", "http.html", $filePath);
                }

                if (!file_exists($filePath)) {
                    $this->fail("Documentation file $filePath does not exist.");
                }
            }

            $fileContent = file_get_contents($filePath);

            if ($fileContent === false) {
                $this->fail("Unable to read the file $filePath.");
            }

            foreach (array_keys($functions) as $function) {
                $containsFunction = strpos($fileContent, $function) !== false;
                $this->assertTrue($containsFunction, "Function $function is not documented in $filePath.");
            }
        }
    }
}
