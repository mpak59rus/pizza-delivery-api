<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Get all NON-EMPTY categories
     *
     * @return void
     */
    public function testIndex()
    {
        $oneProductCategory = factory(Category::class)->create();
        $oneProductCategory->products()->createMany(
            factory(Product::class, 1)->make()->toArray()
        );

        $fiveProductCategory = factory(Category::class)->create();
        $fiveProductCategory->meals()->createMany(
            factory(Product::class, 5)->make()->toArray()
        );

        $emptyCategory = factory(Category::class)->create();

        $expectedJson = $oneProductCategory
            ->whereId($oneProductCategory->id, $fiveProductCategory->id)
            ->get(Category::CATEGORY_FIELDS)
            ->toArray();

        $missingJson = $emptyCategory->toArray();

        $response = $this->json('GET', '/api/categories/');

        $response
            ->assertStatus(200) # OK
            ->assertJsonStructure(Category::CATEGORY_FIELDS)
            ->assertJson($expectedJson)
            ->assertJsonMissing($missingJson);
    }
}
