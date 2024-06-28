<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Helpers\ArrayHelper;
use Symfony\Component\HttpFoundation\Request;
use Blumilk\BLT\Helpers\ContextHelper;

trait HttpRequest
{
    // TODO: unify table structure between request and eloquent(and other places), do we use key-value or dont?
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
    public function requestBodyContainsKeyValuePair(string $key, string|array $value): void
    {
        $this->request->request->set($key, $value);
    }

    /**
     * @Given request body contains:
     */
    public function requestBodyContains(TableNode $table): void
    {
        foreach ($table as $row) {
            $key = $row["key"];
            $value = $row["value"];

            if (ContextHelper::getHelper("array")->hasArraySyntax($value)) {
                $value = ContextHelper::getHelper("array")->toArray($value, ",");
            }
            $this->requestBodyContainsKeyValuePair($key, $value);
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
}
