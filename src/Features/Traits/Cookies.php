<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieFactory;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert;

trait Cookies
{
    use Application;

    /**
     * @When I set cookie :name with value :value
     * @When I create a cookie named :name with value :value
     * @When I add a cookie :name with value :value
     */
    public function setCookie(string $name, string $value): void
    {
        $cookieFactory = $this->getContainer()->make(CookieFactory::class);
        $cookieFactory->queue($name, $value);
    }

    /**
     * @Then cookie :name should have value :value
     * @Then the cookie :name should contain value :value
     * @Then the cookie named :name should have the value :value
     */
    public function assertCookieValue(string $name, string $value): void
    {
        $request = $this->getContainer()->make(Request::class);
        $cookieValue = $request->cookie($name);
        Assert::assertEquals($value, $cookieValue, "Cookie $name does not have the expected value $value.");
    }

    /**
     * @When I delete cookie :name
     * @When I remove the cookie :name
     * @When I clear the cookie :name
     */
    public function deleteCookie(string $name): void
    {
        $cookieFactory = $this->getContainer()->make(CookieFactory::class);
        $cookieFactory->queue($cookieFactory->forget($name));
    }

    /**
     * @Then the cookie :name should be missing
     * @Then the cookie named :name should not be present
     */
    public function assertCookieNotExists(string $name): void
    {
        $request = $this->getContainer()->make(Request::class);
        $cookieValue = $request->cookie($name);
        Assert::assertNull($cookieValue, "Cookie $name should not exist.");
    }

    /**
     * @Then the following cookies should be present:
     * @Then the cookies should be set to:
     */
    public function assertCookiesExist(TableNode $table): void
    {
        $request = $this->getContainer()->make(Request::class);

        foreach ($table as $row) {
            $cookieValue = $request->cookie($row['name']);
            Assert::assertEquals($row['value'], $cookieValue, "Cookie {$row['name']} does not have the expected value {$row['value']}.");
        }
    }
}
