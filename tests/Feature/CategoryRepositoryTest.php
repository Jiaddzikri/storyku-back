<?php

namespace Tests\Feature;

use App\Repositories\CategoryRepositoryImplementation;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    private  CategoryRepositoryImplementation $categoryRepositoryImplememntation;
    protected function setUp(): void
    {
        parent::setUp();

        DB::table("categories")->delete();

        $this->categoryRepositoryImplememntation = App::make(CategoryRepositoryInterface::class);
    }
    /**
     * A basic feature test example.
     */

     public function testGetCategoriesData()
     {
        DB::table("categories")->insert([
            "name" => "Fisika"
        ]);

        $categories = $this->categoryRepositoryImplememntation->getCategories();

        self::assertNotNull($categories);
        self::assertDatabaseHas("categories", [
            "name" => "Fisika"
        ]);

     }
}
