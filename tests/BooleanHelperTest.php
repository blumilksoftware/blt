<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\BooleanHelper;
use PHPUnit\Framework\TestCase;

class BooleanHelperTest extends TestCase
{
    public function testReturnsTrueForStringTrue(): void
    {
        $input = "true";
        $expected = true;

        $booleanHelper = new BooleanHelper();
        $actual = $booleanHelper->toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForStringFalse(): void
    {
        $input = "false";
        $expected = false;

        $booleanHelper = new BooleanHelper();
        $actual = $booleanHelper->toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForInvalidString(): void
    {
        $input = "invalid";
        $expected = false;

        $booleanHelper = new BooleanHelper();
        $actual = $booleanHelper->toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForEmptyString(): void
    {
        $input = "";
        $expected = false;

        $booleanHelper = new BooleanHelper();
        $actual = $booleanHelper->toBoolean($input);

        self::assertSame($expected, $actual);
    }
}
