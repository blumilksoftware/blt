<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieFactory;
use PHPUnit\Framework\Assert;

trait Cookies
{
    use Application;
    use HttpRequest;

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
        $cookieValue = $this->request->cookies->get($name);
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
        $cookieValue = $this->request->cookies->get($name);
        Assert::assertNull($cookieValue, "Cookie $name should not exist.");
    }

    /**
     * @Then the following cookies should be present:
     * @Then the cookies should be set to:
     */
    public function assertCookiesExist(TableNode $table): void
    {
        foreach ($table as $row) {
            $cookieValue = $this->request->cookies->get($row["name"]);
            Assert::assertEquals($row["value"], $cookieValue, "Cookie {$row["name"]} does not have the expected value {$row["value"]}.");
        }
    }
}
