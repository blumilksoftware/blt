<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\NullableHelper;
use PHPUnit\Framework\TestCase;

class NullableHelperTest extends TestCase
{
    public function testToNullableReturnsNullForNullString(): void
    {
        $input = "null";
        $expected = null;

        $actual = NullableHelper::toNullable($input);

        self::assertSame($expected, $actual);
    }

    public function testToNullableReturnsInputForNotEmptyString(): void
    {
        $input = "someValue";
        $expected = "someValue";

        $actual = NullableHelper::toNullable($input);

        self::assertSame($expected, $actual);
    }

    public function testToNullableReturnsInputForEmptyString(): void
    {
        $input = "";
        $expected = "";

        $actual = NullableHelper::toNullable($input);

        self::assertSame($expected, $actual);
    }
}
