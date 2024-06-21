<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\BooleanHelper;
use Blumilk\BLT\Helpers\DotNotationHelper;
use Blumilk\BLT\Helpers\NullableHelper;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
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

    public function testGetValueUsingDotNotation(): void
    {
        $array = [
            "user" => [
                "profile" => [
                    "email" => "user@example.com",
                    "age" => 25,
                ],
            ],
        ];

        $this->assertEquals("user@example.com", DotNotationHelper::getValueUsingDotNotation($array, "user.profile.email"));
        $this->assertEquals(25, DotNotationHelper::getValueUsingDotNotation($array, "user.profile.age"));
        $this->assertNull(DotNotationHelper::getValueUsingDotNotation($array, "user.profile.name"));
    }

    public function testGetValueUsingDotNotationWithEmptyPath(): void
    {
        $array = [
            "user" => [
                "profile" => [
                    "email" => "user@example.com",
                ],
            ],
        ];

        $this->assertNull(DotNotationHelper::getValueUsingDotNotation($array, ""));
    }

    public function testGetValueUsingDotNotationWithInvalidPath(): void
    {
        $array = [
            "user" => [
                "profile" => [
                    "email" => "user@example.com",
                ],
            ],
        ];

        $this->assertNull(DotNotationHelper::getValueUsingDotNotation($array, "user.address.street"));
    }

    public function testGetValueUsingDotNotationWithNestedArray(): void
    {
        $array = [
            "user" => [
                "profile" => [
                    "details" => [
                        "email" => "user@example.com",
                    ],
                ],
            ],
        ];

        $this->assertEquals("user@example.com", DotNotationHelper::getValueUsingDotNotation($array, "user.profile.details.email"));
    }
}
