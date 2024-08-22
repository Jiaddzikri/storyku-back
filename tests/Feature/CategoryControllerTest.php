<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::table('categories')->delete();
    }

    public function testGetCategorySuccess(): void
    {
        DB::table('categories')->insert([
            "category" => "fisika"
        ]);

        $response = $this->get("/api/categories");

        $response->assertStatus(200);
    }

    public function testGetCategoryNotFound(): void
    {
        $response = $this->get("/api/categories");
        $response->assertStatus(404);

        $response->assertJson([
            "message" => [
                "category" => "categories not found"
            ]
        ]);
    }
}
