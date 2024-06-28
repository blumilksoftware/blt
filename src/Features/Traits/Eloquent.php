<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Helpers\LaravelRelations;
use Blumilk\BLT\Helpers\ClassHelper;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
use Blumilk\BLT\Helpers\ContextHelper;

trait Eloquent
{
    /**
     * @Given there is a model :model in the database
     * @Given there is a :model in the database
     */
    public function seedModelInTheDatabase(string $model, ?TableNode $table = null, bool $hasFactory = true): void
    {
        $modelClass = ContextHelper::getHelper("class")->recognizeObjectClass($model);

        $attributes = $table ? $table->getRowsHash() : [];

        if ($hasFactory) {
            $modelClass::factory()->create($attributes);
        } else {
            $modelClass::create($attributes);
        }
    }

    /**
     * @Given there is a model :model in the database without factory
     * @Given there is a :model in the database without factory
     */
    public function seedModelWithoutFactory(string $model, ?TableNode $table = null): void
    {
        $this->seedModelInTheDatabase($model, $table, false);
    }

    /**
     * @Then the model :model exists in the database
     */
    public function assertModelExistsInTheDatabase(string $model): void
    {
        $modelClass = ContextHelper::getHelper("class")->recognizeObjectClass($model);

        Assert::assertTrue($modelClass::query()->exists(), "The model $model does not exist in the database.");
    }

    /**
     * @Given there are :count :model objects in the database
     * @Given there are :count :model in the database
     */
    public function thereAreModelsInTheDatabase(string $model, int $count): void
    {
        $modelClass = ContextHelper::getHelper("class")->recognizeObjectClass($model);
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
        $model1Class = ContextHelper::getHelper("class")->recognizeObjectClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

       ContextHelper::getHelper("laravelRelations")->assertRelation($instance, $relation, HasMany::class);
    }

    /**
     * @Then the model :model1 belongs to :model2
     */
    public function theModelBelongsTo(string $model1, string $model2): void
    {
        $model1Class = ContextHelper::getHelper("class")->recognizeObjectClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

       ContextHelper::getHelper("laravelRelations")->assertRelation($instance, $relation, BelongsTo::class);
    }

    /**
     * @Then the model :model1 has one :model2
     */
    public function theModelHasOne(string $model1, string $model2): void
    {
        $model1Class = ContextHelper::getHelper("class")->recognizeObjectClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

       ContextHelper::getHelper("laravelRelations")->assertRelation($instance, $relation, HasOne::class);
    }

    /**
     * @Then the model :model1 belongs to many :model2
     */
    public function theModelBelongsToMany(string $model1, string $model2): void
    {
        $model1Class = ContextHelper::getHelper("class")->recognizeObjectClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

       ContextHelper::getHelper("laravelRelations")->assertRelation($instance, $relation, BelongsToMany::class);
    }

    /**
     * @Then the model :model1 has :count related :model2
     */
    public function theModelHasExpectedNumberOfRelated(string $model1, string $model2, int $count): void
    {
        $model1Class = ContextHelper::getHelper("class")->recognizeObjectClass($model1);
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
