<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

trait Eloquent
{
    /**
     * @Given there is :count :model object in database
     * @Given there should be :count :model object in database
     * @Given there are :count :model objects in database
     * @Given there should be :count :model objects in database
     */
    public function thereAreModelsInDatabase(string $model, int $count): void
    {
        $modelClass = $this->recognizeModelClass($model);
        Assert::assertEquals($count, $modelClass::query()->count());
    }

    protected function getModelNamespace(): string
    {
        return "App\\Models\\";
    }

    protected function recognizeModelClass(string $model): string
    {
        if (str_contains($model, "\\")) {
            return $model;
        }

        $model = Str::ucfirst(Str::singular($model));

        return $this->getModelNamespace() . $model;
    }
}
