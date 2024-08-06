<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\NullableHelper;
use PHPUnit\Framework\TestCase;

class NullableHelperTest extends TestCase
{
    public function testReturnsNullForNullString(): void
    {
        $input = "null";
        $expected = null;

        $nullableHelper = new NullableHelper();
        $actual = $nullableHelper->toNullable($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsInputForNotEmptyString(): void
    {
        $input = "someValue";
        $expected = "someValue";

        $nullableHelper = new NullableHelper();
        $actual = $nullableHelper->toNullable($input);

        self::assertSame($expected, $actual);
    }

    public function testReturnsInputForEmptyString(): void
    {
        $input = "";
        $expected = "";

        $nullableHelper = new NullableHelper();
        $actual = $nullableHelper->toNullable($input);

        self::assertSame($expected, $actual);
    }
}
