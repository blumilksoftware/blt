<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\BooleanHelper;
use Blumilk\BLT\Helpers\NullableHelper;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testBehatNullReturnsNullForNullString(): void
    {
        $input = "null";
        $expected = null;

        $actual = NullableHelper::behatNull($input);

        self::assertSame($expected, $actual);
    }

    public function testBehatNullReturnsInputForNonNullString(): void
    {
        $input = "someValue";
        $expected = "someValue";

        $actual = NullableHelper::behatNull($input);

        self::assertSame($expected, $actual);
    }

    public function testBehatNullReturnsInputForEmptyString(): void
    {
        $input = "";
        $expected = "";

        $actual = NullableHelper::behatNull($input);

        self::assertSame($expected, $actual);
    }

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
