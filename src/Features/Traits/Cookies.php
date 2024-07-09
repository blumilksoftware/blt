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
     * @When cookie :name with value :value is set
     * @When cookie named :name with value :value is created
     * @When cookie :name with value :value is added
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
     * @When cookie :name is deleted
     * @When cookie :name is removed
     * @When cookie :name is cleared
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
