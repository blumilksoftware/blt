<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

trait Eloquent
{
    /**
     * @Given there is a model :model in the database
     * @Given there is a :model in the database
     */
    public function thereIsAModelInTheDatabase(string $model): void
    {
        $modelClass = $this->recognizeModelClass($model);
        if (!$modelClass::query()->exists()) {
            $modelClass::factory()->create();
        }
        Assert::assertTrue($modelClass::query()->exists(), "The model $model does not exist in the database.");
    }

    /**
     * @Given there are :count :model objects in the database
     * @Given there are :count :model in the database
     */
    public function thereAreModelsInTheDatabase(string $model, int $count): void
    {
        $modelClass = $this->recognizeModelClass($model);
        $existingCount = $modelClass::query()->count();
        if ($existingCount < $count) {
            $modelClass::factory()->count($count - $existingCount)->create();
        }
        Assert::assertEquals($count, $modelClass::query()->count());
    }

    /**
     * @Then the model :model1 has many :model2
     */
    public function theModelHasMany(string $model1, string $model2): void
    {
        $model1Class = $this->recognizeModelClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $related = $instance->{$relation}();

        Assert::assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $related,
            "The relation $relation is not of type HasMany.",
        );
    }

    /**
     * @Then the model :model1 belongs to :model2
     */
    public function theModelBelongsTo(string $model1, string $model2): void
    {
        $model1Class = $this->recognizeModelClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $related = $instance->{$relation}();

        Assert::assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $related,
            "The relation $relation is not of type BelongsTo.",
        );
    }

    /**
     * @Then the model :model1 has one :model2
     */
    public function theModelHasOne(string $model1, string $model2): void
    {
        $model1Class = $this->recognizeModelClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $related = $instance->{$relation}();

        Assert::assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasOne',
            $related,
            "The relation $relation is not of type HasOne.",
        );
    }

    /**
     * @Then the model :model1 belongs to many :model2
     */
    public function theModelBelongsToMany(string $model1, string $model2): void
    {
        $model1Class = $this->recognizeModelClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $related = $instance->{$relation}();

        Assert::assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsToMany',
            $related,
            "The relation $relation is not of type BelongsToMany.",
        );
    }

    /**
     * @Then the model :model1 has :count related :model2
     */
    public function theModelHasExpectedNumberOfRelated(string $model1, string $model2, int $count): void
    {
        $model1Class = $this->recognizeModelClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $relatedCount = $instance->{$relation}()->count();

        Assert::assertEquals(
            $count,
            $relatedCount,
            "The model $model1 does not have $count related $relation.",
        );
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
