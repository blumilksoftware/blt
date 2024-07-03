<?php

class

FileCrawler
{
    private array $files;
    private array $phrases;
    private array $filePaths;

    public function __construct()
    {
        $this->files = [];
        $this->phrases = [];
        $this->filePaths = [];
    }

    private function getPhrases($path)
    {

        $lines = file($path);
        $functions = [];
        $phrases = [];
        foreach ($lines as $line) {
            if(str_contains($line, "* @")){
                $phrases[] = trim($line);
            }
            if(str_contains($line, "public function")){
                if (preg_match('/function\s+([a-zA-Z0-9_]+)\s*\(/', $line, $matches)) {
                    $functionName = $matches[1];
                    $functions[$functionName] = $phrases;
                    $phrases = [];
                }
            }
            $filename = basename($path, ".php");
            $this->phrases[$filename] = $functions;
        }
    }


    private function getFiles($path)
    {
        return scandir($path);
    }

    public function runPhrasesCrawler($path)
    {
        $filePaths = $this->getFiles($path);
        foreach ($filePaths as $filePath){
            $this->getPhrases($path . "/" . $filePath);
        }
        $file = fopen("phrases.json", "w");

        fwrite($file,json_encode($this->phrases));
    }
}

$fileCrawler = new FileCrawler();
$fileCrawler->runPhrasesCrawler("src/Features/Traits/");

?>

