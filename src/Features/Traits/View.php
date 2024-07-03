<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Response;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Illuminate\View\View as LaravelView;

use PHPUnit\Framework\Assert;
use function PHPUnit\Framework\assertContains;
use Exception;

trait View
{
    use Application;
    use Http;

    protected ?LaravelView $view = null;
    protected TestResponse $testResponse;

    /**
     * @Given user is looking at :page :view view
     * @Given user is looking at :view view
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
     * @Then view should contain :data
     */
    public function theViewContains(string $data): void
    {
        $viewData = $this->view->getData();
        Assert::assertContains($data, $viewData);
    }

    /**
     * @Then view response contains:
     */
    public function viewResponseContains(TableNode $table): void
    {

        if ($this->response instanceof IlluminateResponse) {


            $this->testResponse = TestResponse::fromBaseResponse($this->response);

            foreach ($table as $row) {
                $this->testResponse->assertViewHas($row["key"], $row["value"]);
            }
        }else{
            throw new Exception("Response is not instance of IlluminateResponse");
        }
    }
}
