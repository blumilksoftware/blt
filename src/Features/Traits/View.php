<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Support\Str;
use Illuminate\View\View as LaravelView;
use PHPUnit\Framework\Assert;

trait View
{
    use Application;
    use Http;

    private LaravelView $view;

    /**
     * @Given user is looking at :page :view view
     * * @Given user is looking at :view view
     * @Given user is looking at :page :view view with:
     * @Given user is looking at :view view with:
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

        if (!$page) {
            $this->view = $this->getContainer()->make("view")->make($view, $params);
        } else {
            $this->view = $this->getContainer()->make("view")->make("{$page}.{$view}");
        }
    }

    /**
     * @Then response should contain :data in the view
     */
    public function viewContains(string $data): void
    {
        Assert::assertStringContainsString($data, $this->view->render());
    }
}
