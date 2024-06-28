<?php

class FileCrawler
{
    private array $phrases;

    public function __construct()
    {
        $this->phrases = [];
    }

    private function getPhrases($path)
    {
        $lines = file($path);
        $functions = [];
        $phrases = [];
        foreach ($lines as $line) {
            if (str_contains($line, "* @")) {
                $phrases[] = trim($line);
            }
            if (str_contains($line, "function")) {
                if (preg_match('/function\s+([a-zA-Z0-9_]+)\s*\(/', $line, $matches)) {
                    $functionName = $matches[1];
                    $functions[$functionName] = $phrases;
                    $phrases = [];
                }
            }
        }
        $filename = basename($path, ".php");
        $this->phrases[$filename]["path"] = $path;
        $this->phrases[$filename]["functions"] = $functions;
    }

    private function getFiles($path)
    {
        $files = array_diff(scandir($path), array('.', '..'));
        $phpFiles = array_filter($files, function($file) use ($path) {
            return is_file($path . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php';
        });
        return $phpFiles;
    }

    public function runPhrasesCrawler($path)
    {
        $filePaths = $this->getFiles($path);
        foreach ($filePaths as $filePath) {
            $this->getPhrases($path . $filePath);
        }
        $file = fopen("phrases.json", "w");
        fwrite($file, json_encode($this->phrases));
        fclose($file);
    }
}

$fileCrawler = new FileCrawler();
$fileCrawler->runPhrasesCrawler("src/Features/Traits/");

?>
