<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait Http
{
    use Application;

    protected Request $request;
    protected Response $response;

    /**
     * @Given a user is requesting :url
     * @Given a user is requesting :url :method using
     */
    public function aUserIsRequesting(string $endpoint, string $method = Request::METHOD_GET): void
    {
        $this->request = Request::create($endpoint, $method);
    }

    /**
     * @When a request is sent
     */
    public function aRequestIsSent(): void
    {
        $this->response = $this->getContainer()->handle($this->request);
        $this->response->send();
    }

    /**
     * @Given request body contains :key equal :value
     */
    public function requestBodyContainsKeyValuePair(string $key, string $value): void
    {
        $this->request[$key] = $value;
    }

    /**
     * @Given request body contains:
     */
    public function requestBodyContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->requestBodyContainsKeyValuePair($row["key"], $row["value"]);
        }
    }

    /**
     * @Given request headers contains :header equal :value
     */
    public function requestHeadersContainsKeyValuePair(string $header, string $value): void
    {
        $this->request->headers->set($header, $value);
    }

    /**
     * @Given request headers contains:
     */
    public function requestHeadersContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->requestHeadersContainsKeyValuePair($row["header"], $row["value"]);
        }
    }

    /**
     * @Then a response status code should be :status
     */
    public function aResponseStatusCodeShouldBe(int $status): void
    {
        Assert::assertEquals($status, $this->response->getStatusCode());
    }
}
