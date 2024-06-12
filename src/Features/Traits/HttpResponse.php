<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

trait HttpResponse
{
    protected Response $response;

    /**
     * @When a request is sent
     */
    public function aRequestIsSent(): void
    {
        $this->response = $this->getContainer()->handle($this->request);
        $this->response->send();
    }

    /**
     * @Then a response status code should be :status
     */
    public function aResponseStatusCodeShouldBe(int $status): void
    {
        Assert::assertEquals($status, $this->response->getStatusCode());
    }

    /**
     * @Given a response HTML should contain :phrase phrase
     */
    public function aResponseHTMLShouldContainPhrase(string $phrase): void
    {
        Assert::assertStringContainsString($phrase, $this->response->getContent());
    }

    /**
     * @Given a response HTML should contain CSRF token
     */
    public function aResponseHTMLShouldContainCSRFToken(): void
    {
        $converter = new CssSelectorConverter();
        $xPath = $converter->toXPath("form input[name=\"_token\"]");

        $crawler = new Crawler($this->response->getContent());
        $node = $crawler->filterXPath($xPath)->first();

        Assert::assertNotNull($node?->attr("value"));
    }

    /**
     * @Then the response should be JSON
     */
    public function aResponseShouldBeJson(): void
    {
        Assert::assertJson($this->response->getContent());
    }

    /**
     * @Then the response should contain JSON:
     */
    public function aResponseShouldContainJson(TableNode $table): void
    {
        $json = json_decode($this->response->getContent(), true);

        foreach ($table->getRowsHash() as $key => $value) {
            Assert::assertArrayHasKey($key, $json);
            Assert::assertEquals($value, $json[$key]);
        }
    }

    /**
     * @Then the response should contain a JSON fragment:
     */
    public function aResponseShouldContainJsonFragment(TableNode $table): void
    {
        $json = json_decode($this->response->getContent(), true);

        foreach ($table->getRowsHash() as $key => $value) {
            Assert::assertArrayHasKey($key, $json);
            Assert::assertStringContainsString($value, $json[$key]);
        }
    }

    /**
     * @Then the response should have cookie :name
     */
    public function aResponseShouldHaveCookie(string $name): void
    {
        Assert::assertTrue($this->response->headers->has("Set-Cookie"));
        $cookies = $this->response->headers->getCookies();
        $cookieNames = array_map(fn($cookie) => $cookie->getName(), $cookies);
        Assert::assertContains($name, $cookieNames);
    }

    /**
     * @Then the response should have header :header
     */
    public function aResponseShouldHaveHeader(string $header): void
    {
        Assert::assertTrue($this->response->headers->has($header));
    }

    /**
     * @Then the response should have header :header equal to :value
     */
    public function aResponseShouldHaveHeaderEqualTo(string $header, string $value): void
    {
        Assert::assertEquals($value, $this->response->headers->get($header));
    }

    /**
     * @Then the response should have status :status
     */
    public function aResponseShouldHaveStatus(int $status): void
    {
        Assert::assertEquals($status, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be OK
     */
    public function aResponseShouldBeOk(): void
    {
        Assert::assertEquals(200, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be created
     */
    public function aResponseShouldBeCreated(): void
    {
        Assert::assertEquals(Response::HTTP_CREATED, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be no content
     */
    public function aResponseShouldBeNoContent(): void
    {
        Assert::assertEquals(204, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be bad request
     */
    public function aResponseShouldBeBadRequest(): void
    {
        Assert::assertEquals(400, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be unauthorized
     */
    public function aResponseShouldBeUnauthorized(): void
    {
        Assert::assertEquals(401, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be forbidden
     */
    public function aResponseShouldBeForbidden(): void
    {
        Assert::assertEquals(403, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be not found
     */
    public function aResponseShouldBeNotFound(): void
    {
        Assert::assertEquals(404, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be conflict
     */
    public function aResponseShouldBeConflict(): void
    {
        Assert::assertEquals(409, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be unprocessable
     */
    public function aResponseShouldBeUnprocessable(): void
    {
        Assert::assertEquals(422, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be too many requests
     */
    public function aResponseShouldBeTooManyRequests(): void
    {
        Assert::assertEquals(429, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be gone
     */
    public function aResponseShouldBeGone(): void
    {
        Assert::assertEquals(410, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be service unavailable
     */
    public function aResponseShouldBeServiceUnavailable(): void
    {
        Assert::assertEquals(503, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be found
     */
    public function aResponseShouldBeFound(): void
    {
        Assert::assertEquals(302, $this->response->getStatusCode());
    }

    /**
     * @Then the response should be redirected to :url
     */
    public function aResponseShouldBeRedirectedTo(string $url): void
    {
        Assert::assertTrue($this->response->isRedirect($url));
    }

    /**
     * @Then the response should have a header :header containing :value
     */
    public function aResponseShouldHaveHeaderContaining(string $header, string $value): void
    {
        Assert::assertStringContainsString($value, $this->response->headers->get($header));
    }

    /**
     * @Then the response should have no content
     */
    public function aResponseShouldHaveNoContent(): void
    {
        Assert::assertEmpty($this->response->getContent());
    }
}
