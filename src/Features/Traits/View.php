<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;
use Illuminate\View\View as LaravelView;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

trait View
{
    use Application;
    use Http;

    private ?LaravelView $view = null;

    /**
     * @Given user is looking at :page :view view
     * * @Given user is looking at :view view
     * @Given user is looking at :page :view view with:
     * @Given user is looking at :view view with:
     * @throws BindingResolutionException
     */
    public function userIsLookingAtView(string $view, string $page = "", ?TableNode $table = null): void
    {
        $page = Str::slug($page);
        $view = Str::slug($view);
        $params = [];

        if ($table) {
            foreach ($table->getHash() as $row) {
                $params[$row["key"]] = $row["value"];
            }
        }

        $viewName = $page ? "$page.$view" : $view;
        $this->view = $this->getContainer()->make("view")->make($viewName, $params);
    }

    /**
     * @When user is accessing :endpoint endpoint
     * @When user is accessing :endpoint endpoint using :method method
     */
    public function userIsAccessing(string $endpoint, string $method = Request::METHOD_GET): void
    {
        $this->aUserIsRequesting($endpoint, $method);
        $this->aRequestIsSent();
    }

    /**
     * @Then view should contain :data
     * @throws Throwable
     */
    public function viewContains(string $data): void
    {
        if ($this->view) {
            Assert::assertStringContainsString($data, $this->view->render());
        } elseif ($this->response) {
            Assert::assertStringContainsString($data, $this->response->getContent());
        } else {
            throw new Exception("No view or response found");
        }
    }
}
