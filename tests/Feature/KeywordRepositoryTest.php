<?php

namespace Tests\Feature;

use App\Models\Stories;
use App\Repositories\KeywordRepositoryImplementation;
use App\Repositories\KeywordRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class KeywordRepositoryTest extends TestCase
{
    private KeywordRepositoryImplementation $keywordRepositoryImplementation;
    protected function setUp(): void
    {
        parent::setUp();
        DB::table("keywords")->delete();
        DB::table("stories")->delete();

        $this->keywordRepositoryImplementation = App::make(KeywordRepositoryInterface::class);
    }

    protected function createDataDummy() 
    {
        return Stories::create([
            "title" => "title",
            "author" => "john doe",
            "synopsis" => "long text",
            "status" => "draft",
            "cover_image" => "/path/to/image"
        ]);
    }

    public function testInsertKeyword()
    {
        $dummy = $this->createDataDummy();
        var_dump($dummy->id);

        $saved =  $this->keywordRepositoryImplementation->insert([
            "stories_id" => $dummy->id,
            "name" => "Science & Fiction"
        ]);
        self::assertNotNull($saved);
        self::assertDatabaseHas("keywords", [
            "id" => $saved->id,
            "stories_id" => $dummy->id,
            "name" => $saved->name
        ]);

    }

    
}
