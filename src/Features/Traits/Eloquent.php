<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Helpers\RecognizeClassHelper;
use Blumilk\BLT\LaravelRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

trait Eloquent
{
    /**
     * @Given there is a model :model in the database:
     * @Given there is a :model in the database:
     */
    public function seedModelInTheDatabase(string $model, ?TableNode $table = null): void
    {
        $modelClass = RecognizeClassHelper::recognizeObjectClass($model);
        $attributes = $table ? $table->getRowsHash() : [];

        if (method_exists($modelClass, "factory")) {
            $modelClass::factory()->create($attributes);
        } else {
            $modelClass::create($attributes);
        }
    }

    /**
     * @Then the model :model exists in the database
     */
    public function assertModelExistsInTheDatabase(string $model): void
    {
        $modelClass = RecognizeClassHelper::recognizeObjectClass($model);

        Assert::assertTrue($modelClass::query()->exists(), "The model $model does not exist in the database.");
    }

    /**
     * @Given there are :count :model objects in the database
     * @Given there are :count :model in the database
     */
    public function thereAreModelsInTheDatabase(string $model, int $count): void
    {
        $modelClass = RecognizeClassHelper::recognizeObjectClass($model);
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
        $model1Class = RecognizeClassHelper::recognizeObjectClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $this->assertRelation($instance, $relation, LaravelRelations::HAS_MANY);
    }

    /**
     * @Then the model :model1 belongs to :model2
     */
    public function theModelBelongsTo(string $model1, string $model2): void
    {
        $model1Class = RecognizeClassHelper::recognizeObjectClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $this->assertRelation($instance, $relation, LaravelRelations::BELONGS_TO);
    }

    /**
     * @Then the model :model1 has one :model2
     */
    public function theModelHasOne(string $model1, string $model2): void
    {
        $model1Class = RecognizeClassHelper::recognizeObjectClass($model1);
        $relation = Str::singular($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $this->assertRelation($instance, $relation, LaravelRelations::HAS_ONE);
    }

    /**
     * @Then the model :model1 belongs to many :model2
     */
    public function theModelBelongsToMany(string $model1, string $model2): void
    {
        $model1Class = RecognizeClassHelper::recognizeObjectClass($model1);
        $relation = Str::plural($model2);
        $instance = $model1Class::first() ?: $model1Class::factory()->create();

        Assert::assertTrue(
            method_exists($instance, $relation),
            "The model $model1 does not have a $relation relation method.",
        );

        $this->assertRelation($instance, $relation, LaravelRelations::BELONGS_TO_MANY);
    }

    /**
     * @Then the model :model1 has :count related :model2
     */
    public function theModelHasExpectedNumberOfRelated(string $model1, string $model2, int $count): void
    {
        $model1Class = RecognizeClassHelper::recognizeObjectClass($model1);
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

    protected function assertRelation(Model $instance, string $relation, string $relationType): void
    {
        $related = $instance->{$relation}();

        Assert::assertInstanceOf(
            $relationType,
            $related,
            "The relation $relation is not of type $relationType.",
        );
    }
}
