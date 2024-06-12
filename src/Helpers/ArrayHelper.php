<?php

declare(strict_types=1);

namespace Blumilk\BLT\Helpers;

use SimpleXMLElement;

class ArrayHelper
{
    public static function jsonToArray(string $json): array
    {
        return json_decode($json, true);
    }

    public static function arrayToJson(array $table): string
    {
        return json_encode($table);
    }

    public static function xmlToArray(string $xml): array
    {
        return json_decode(json_encode(simplexml_load_string($xml)), true);
    }

    public static function arrayToXml(array $table): string
    {
        $xml = new SimpleXMLElement("<root/>");
        array_walk_recursive($table, [$xml, "addChild"]);

        return $xml->asXML();
    }
}
