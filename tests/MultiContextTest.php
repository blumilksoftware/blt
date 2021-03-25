<?php

use Behat\Behat\Context\Context;
use Blumilk\BLT\Features\Toolbox;
use Blumilk\BLT\Features\Traits\Database;
use Blumilk\BLT\Features\Traits\Http;
use Blumilk\BLT\Features\Traits\Middleware;
use PHPUnit\Framework\TestCase;

class MultiContextTest extends TestCase
{
    public function testIfMultiContextClassIsBuildingProperly(): void
    {
        $context = new class implements Context {
            use Database, Http, Middleware;
        };

        $this->assertTrue(method_exists($context, "refreshDatabase"));
        $this->assertTrue(method_exists($context, "getContainer"));
        $this->assertFalse(method_exists($context, "somethingTestable"));
    }

    public function testIfToolboxClassIsBuildingProperly(): void
    {
        $context = new Toolbox();

        $this->assertTrue(method_exists($context, "refreshDatabase"));
        $this->assertTrue(method_exists($context, "applicationIsBootedWithConfig"));
        $this->assertTrue(method_exists($context, "getContainer"));
        $this->assertFalse(method_exists($context, "somethingTestable"));
    }
}
