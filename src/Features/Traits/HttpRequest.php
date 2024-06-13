<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpFoundation\Request;

trait HttpRequest
{
    protected Request $request;

    /**
     * @Given a user is requesting :url
     * @Given a user is requesting :url using :method method
     */
    public function aUserIsRequesting(string $endpoint, string $method = Request::METHOD_GET): void
    {
        $this->request = Request::create($endpoint, $method);
    }

    /**
     * @Given request body contains :key equal :value
     */
    public function requestBodyContainsKeyValuePair(string $key, $value): void
    {
        $this->request->request->set($key, $value);
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
     * @Given request form params contains:
     */
    public function thereAreValuesInFormParams(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->request->request->set($row["key"], $row["value"]);
        }
    }

    /**
     * @Given request query params contains:
     */
    public function requestQueryParamsContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->request->query->set($row["key"], $row["value"]);
        }
    }

    /**
     * @Given request cookies contains:
     */
    public function requestCookiesContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->request->cookies->set($row["key"], $row["value"]);
        }
    }

    /**
     * @Given request server params contains:
     */
    public function requestServerParamsContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->request->server->set($row["key"], $row["value"]);
        }
    }

    /**
     * @Given request has bearer token :token
     */
    public function requestHasBearerToken(string $token): void
    {
        $this->request->headers->set("Authorization", "Bearer " . $token);
    }

    /**
     * @Given request has Accept Language header set to :language
     */
    public function requestHasAcceptLanguage(string $language): void
    {
        $this->request->headers->set("Accept-Language", $language);
    }

    /**
     * @Given request has Content Type header set to :contentType
     */
    public function requestHasContentType(string $contentType): void
    {
        $this->request->headers->set("Content-Type", $contentType);
    }
}
