<?php

namespace Tests\Feature;

use App\Models\Stories;
use App\Repositories\StoryRepositoryImplementation;
use App\Repositories\StoryRepsoitoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StoryRepositoryTest extends TestCase
{
    private StoryRepositoryImplementation $storyRepositoryImplementation;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table("stories")->delete();

        $this->storyRepositoryImplementation = App::make(StoryRepsoitoryInterface::class);
    }

    protected function createDummyData() 
    {
        $create = Stories::create([
            "title" => "title1",
            "author" => "john doe",
            "status" => "publish",
            "cover_image" => "/path/to/image",
        ]);

        return $create;
    }

    public function testGetStories() 
    {
        $this->createDummyData();
        $stories = $this->storyRepositoryImplementation->getStories();
        self::assertCount(1, $stories);
        self::assertInstanceOf(Collection::class,$stories);
        self::assertNotNull($stories);
    }

    public function testGetStoriesEmpty() 
    {
        $stories = $this->storyRepositoryImplementation->getStories();
        self::assertCount(0, $stories);
    }

    public function testGetStory() 
    {
        $dummy = $this->createDummyData();
        $story =  $this->storyRepositoryImplementation->getStoryById($dummy->id);
        self::assertNotNull($story);
        self::assertEquals($dummy->id, $story->id);        
    }

    public function testGetStoryNotFound()
    {
        $story = $this->storyRepositoryImplementation->getStoryById(null);

        self::assertNull($story);
    }

    public function testInsert()
    {
        $insert = $this->storyRepositoryImplementation->insert([
            "title" => "title1",
            "author" => "john doe",
            "status" => "draft",
            "cover_image" => "/path/to/image"
        ]);

        self::assertNotNull($insert);
        self::assertDatabaseHas("stories", [
            "id" => $insert->id,
            "title" =>  $insert->title,
            "author" => $insert->author,
            "status" => $insert->status,
            "cover_image" => $insert->cover_image
        ]);
    }

    public function testDelete() 
    {
        $dummy = $this->createDummyData();

        $deleted = $this->storyRepositoryImplementation->delete($dummy->id);

        self::assertTrue($deleted);
        self::assertDatabaseMissing("stories", [
            "title" => $dummy->title,
            "author" => $dummy->author,
            "status" => $dummy->status,
            "cover_image" => $dummy->cover_image
        ]);
    }

    public function testUpdate()
    {
        $dummy = $this->createDummyData();

        $updated = $this->storyRepositoryImplementation->edit(["title" => "title2", "author" => "john yama"], $dummy->id);

        self::assertTrue($updated);
        self::assertDatabaseHas("stories", [
            "id" => $dummy->id,
            "title" => "title2",
            "author" => "john yama",
            "status" => $dummy->status,
            "cover_image" => $dummy->cover_image
        ]);
    }
}
