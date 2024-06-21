<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\BooleanHelper;
use PHPUnit\Framework\TestCase;

class BooleanHelperTest extends TestCase
{
    public function testToBooleanReturnsTrueForStringTrue(): void
    {
        $input = "true";
        $expected = true;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testToBooleanReturnsFalseForStringFalse(): void
    {
        $input = "false";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testToBooleanReturnsFalseForInvalidString(): void
    {
        $input = "invalid";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testToBooleanReturnsFalseForEmptyString(): void
    {
        $input = "";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }
}
