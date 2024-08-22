<?php

namespace Tests\Feature;

use App\Models\Categories;
use App\Models\Chapters;
use App\Models\Keywords;
use App\Models\Stories;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile as HttpUploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StoryControllerTest extends TestCase
{
  protected function setUp(): void
  {
    parent::setUp();

    DB::table("keywords")->delete();
    DB::table("chapters")->delete();
    DB::table("stories")->delete();
    DB::table("categories")->delete();
  }

  protected function createCategoryDummy()
  {
    return Categories::create([
      "name" => "mystery"
    ]);
  }

  protected function createdStoryDummy($category_id)
  {
    return Stories::create([
      "categories_id" => $category_id,
      "title" => "title 1",
      "author" => "john doe",
      "synopsis" => "panjang banget",
      "cover_image" => "lala",
      "status" => "publish",
    ]);
  }

  protected function createdChapterDummy($story_id)
  {
    return Chapters::create([
      "stories_id" => $story_id,
      "title" => "prologue",
      "story" => "panjang",
    ]);
  }

  protected function createdKeywordsDummy($story_id) 
  {
    return Keywords::create([
      "stories_id" => $story_id,
      "name" => "good"
    ]);
  } 

  public function testGetStories()
  {
    $categoryDummy = $this->createCategoryDummy();
    $storyDummy = $this->createdStoryDummy($categoryDummy->id);
    $chapterDummy = $this->createdChapterDummy($storyDummy->id);
    $keywordDummy = $this->createdKeywordsDummy($storyDummy->id);

    $response = $this->get("/api/stories");
    $response->assertStatus(200);
  }

  public function testStoreProductSuccess()
  {
    $dummy = $this->createCategoryDummy();

    $response = $this->post("/api/story", [
      "title" => "Nightmare",
      "author" => "John Doe",
      "synopsis" => "Novel Nightmare mengisahkan tentang seorang pria bernama David, yang hidupnya berubah drastis setelah mengalami mimpi buruk yang terasa sangat nyata. Setiap malam, ia dihantui oleh mimpi yang sama, di mana ia terjebak dalam sebuah rumah tua yang dipenuhi oleh makhluk-makhluk mengerikan. Mimpi itu tidak hanya menakutkan, tetapi juga mulai mempengaruhi kehidupannya di dunia nyata.",
      "status" => "draft",
      "cover_image" => HttpUploadedFile::fake()->image("cover_image.jpg"),
      "category" => $dummy->id,
      "keywords" => ["mystery", "trending", "scary"],
      "chapters" => [
        [
          "title" => "prologue",
          "story" => "prologue..."
        ],
        [
          "title" => "chapter 1",
          "story" => "chapter 1..."
        ]
      ]
    ]);

    $response->assertStatus(201);
    $response->assertJson([
      "message" => "success"
    ]);
  }

  public function testSearchStories()
  {
    $categoryDummy = $this->createCategoryDummy();
    $storyDummy = $this->createdStoryDummy($categoryDummy->id);
    $chapterDummy = $this->createdChapterDummy($storyDummy->id);
    $keywordDummy = $this->createdKeywordsDummy($storyDummy->id);

    $response = $this->get("/api/story?keyword=john");
    $response->assertStatus(200);
  }
}
