<?php

declare(strict_types=1);

namespace Blumilk\BLT\Tests\Helpers;

use Blumilk\BLT\Helpers\DotNotationHelper;
use PHPUnit\Framework\TestCase;

class DotNotationHelperTest extends TestCase
{
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

        $this->assertEquals("user@example.com", data_get($array, "user.profile.email"));
        $this->assertEquals(25, data_get($array, "user.profile.age"));
        $this->assertNull(data_get($array, "user.profile.name"));
    }

    public function testReturnsNullWithEmptyPath(): void
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

    public function testReturnsNullWithInvalidPath(): void
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

    public function testReturnsValueWithNestedArray(): void
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

        $this->assertEquals(["email" => "user@example.com"], DotNotationHelper::getValueUsingDotNotation($array, "user.profile.details"));
    }
}