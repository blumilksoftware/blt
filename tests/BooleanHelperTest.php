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

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForStringFalse(): void
    {
        $input = "false";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForInvalidString(): void
    {
        $input = "invalid";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsFalseForEmptyString(): void
    {
        $input = "";
        $expected = false;

        $actual = BooleanHelper::toBoolean($input);

        self::assertSame($expected, $actual);
    }
}
