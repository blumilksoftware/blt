<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Illuminate\Contracts\Translation\Translator;
use PHPUnit\Framework\Assert;

trait Translations
{
    use Application;

    private string $input;

    /**
     * @Given locale is set to :locale
     * @Given localization is set to :locale
     */
    public function setLocale(string $locale): void
    {
        $this->getContainer()->setLocale($locale);
    }

    /**
     * @When I ask to translate :input
     * @When I ask for translations of :input
     */
    public function askToTranslate(string $input): void
    {
        $this->input = $input;
    }

    /**
     * @Then I should see the following phrases:
     */
    public function assertTranslationMatches(?TableNode $table = null): void
    {
        $translator = $this->getContainer()->get(Translator::class);

        foreach ($table as $row) {
            $this->getContainer()->setLocale($row["locale"]);
            $translation = $translator->get($this->input);

            Assert::assertEquals($row["phrase"], $translation);
        }
    }
}
