<?php

namespace Tests\Feature;

use App\Models\Chapters;
use App\Models\Stories;
use App\Repositories\ChapterRepositoryImplementation;
use App\Repositories\ChapterRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ChapterRepositoryTest extends TestCase
{
  private ChapterRepositoryImplementation $chapterRepositoryImplementation;
  protected function setUp(): void
  {
    parent::setUp();

    DB::table('chapters')->delete();
    DB::table("keywords")->delete();
    DB::table("stories")->delete();

    $this->chapterRepositoryImplementation = App::make(ChapterRepositoryInterface::class);
  }

  protected function createDataDummy()
  {
    return Stories::create([
      "title" => "title",
      "author" => "john doe",
      "synopsis" => "long text",
      "status" => "publish",
    ]);
  }

  public function testInsert()
  {
    $dummy = $this->createDataDummy();
 
    $saved = $this->chapterRepositoryImplementation->insert([
      "stories_id" => $dummy->id,
      "title" => "chapter title",
      "story" => "long story"
    ]);

    self::assertNotNull($saved);
    self::assertDatabaseHas("chapters", [
      "stories_id" => $dummy->id,
      "title" => $saved->title,
      "story" => $saved->story
    ]);
  }

  public function testUpdate() 
  {
    $dummy = $this->createDataDummy();

    $saved = Chapters::create([
      "stories_id" => $dummy->id,
      "title" => "title",
      "story" => "long story"
    ]);

    $updated = $this->chapterRepositoryImplementation->update([
      "title" => "new title",
      "story" => "new Story"
    ], $saved->id);

    self::assertTrue($updated);
    self::assertDatabaseHas("chapters", [
      "id" => $saved->id,
      "stories_id" => $dummy->id,
      "title" => "new title",
      "story" => "new story"
    ]);
  }

  public function testDelete() 
  {
    $dummy = $this->createDataDummy();

    $saved = Chapters::create([
      "stories_id" => $dummy->id,
      "title" => "title",
      "story" => "long story"
    ]);

    $updated = $this->chapterRepositoryImplementation->delete( $saved->id);

    self::assertTrue($updated);
    self::assertDatabaseMissing("chapters", [
      "id" => $saved->id,
      "stories_id" => $dummy->id,
      "title" => "new title",
      "story" => "new story"
    ]);
  }
}
