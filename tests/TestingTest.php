<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Traits\Http;
use Blumilk\BLT\Features\Traits\Testing;
use PHPUnit\Framework\TestCase;

class TestingTest extends TestCase
{
    public function testIfCallMagicMethodIsWorkingProperly(): void
    {
        $context = new class() implements Context {
            use Testing;

            public function test(bool $condition): bool
            {
                $this->assertTrue($condition);

                return $condition;
            }
        };

        $this->assertTrue($context->test(2 > 1));
    }

    public function testIfMoreComplexCombinationsAreWorkingProperly(): void
    {
        $context = new class() implements Context {
            use Http;
            use Testing;

            public function test(): void
            {
                $this->assertTrue(2 > 1);
            }
        };

        $context->aUserIsRequesting("/");
        $context->test();
    }
}
