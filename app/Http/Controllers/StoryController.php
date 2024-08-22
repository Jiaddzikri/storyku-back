<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoryRequest;
use App\Models\Keywords;
use App\Repositories\ChapterRepositoryImplementation;
use App\Repositories\KeywordRepositoryImplementation;
use App\Repositories\StoryRepositoryImplementation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class StoryController extends Controller
{
  public function __construct(private StoryRepositoryImplementation $storyRepositoryImplementation, private KeywordRepositoryImplementation $keywordRepositoryImplementation, private ChapterRepositoryImplementation $chapterRepositoryImplementation) {}

  public function getStories(): JsonResponse
  {
    Log::info("start get story function");
    try {
      $stories = $this->storyRepositoryImplementation->getStories();
      if (sizeof($stories) == 0) throw new Exception("stories data is empty", 404);

      Log::info("data found", ["stories" => $stories]);

      return response()->json([
        "data" => $stories
      ], 200);
    } catch (Exception $error) {
      Log::error($error->getMessage());

      return response()->json([
        "message" => $error->getMessage()
      ], $error->getCode());
    }
  }

  public function store(StoreStoryRequest $request): JsonResponse
  {
    Log::info("start store function from story controller");

    $validatedRequest = $request->validated();

    $validatedRequest["keywords"] = json_decode($validatedRequest["keywords"]);

    Log::info("request validated", ["requests" => $validatedRequest]);

    try {
      $storedImage = $this->storeImage($validatedRequest["cover_image"]);

      $saveStories = $this->storyRepositoryImplementation->insert([
        "title" => $validatedRequest["title"],
        "author" => $validatedRequest["author"],
        "synopsis" => $validatedRequest["synopsis"],
        "categories_id" => (int) $validatedRequest["category"],
        "status" => $validatedRequest["status"],
        "cover_image" => $storedImage
      ]);

      Log::info("save stories data success", ["stories" => $saveStories]);

      foreach ($validatedRequest["keywords"] as $keyword) {
        $saveKeyword = $this->keywordRepositoryImplementation->insert([
          "stories_id" => $saveStories->id,
          "name" => $keyword
        ]);
        Log::info("keyword saved", ["keyword" => $saveKeyword]);
      }

      if (isset($validatedRequest["chapters"])) {
        foreach ($validatedRequest["chapters"] as $chapter) {
          $saveChapter = $this->chapterRepositoryImplementation->insert([
            "stories_id" => $saveStories->id,
            "title" => $chapter["title"],
            "story" => $chapter["story"]
          ]);
          Log::info("chapter saved", ["chapter" => $saveChapter]);
        }
      }

      Log::info("successfully save story data");

      return response()->json([
        "message" => "success",
      ], 201);
    } catch (Exception $error) {
      Log::error("error", ["error" => $error->getMessage()]);
      return response()->json([
        "message" => json_decode($error)
      ], $error->getCode());
    }
  }

  protected function storeImage($image): string
  {
    $generateRandomName = Str::random(10) . "." . $image->getClientOriginalExtension();
    $path = $image->storePubliclyAs("images", $generateRandomName);

    Log::info("storing image success", ["image" => $path]);
    return $path;
  }

  public function search(Request $request): JsonResponse
  {
    Log::info("start search story function");
    $keyword = $request->get("keyword");
    Log::info("keyword", ["keyword" => $keyword]);
    try {
      $stories = $this->storyRepositoryImplementation->searchStories($keyword);

      Log::info("stories",  ["stories" => $stories]);

      if (sizeof($stories) ==  0) throw new Exception("not found", 404);
      return response()->json([
        "data" => $stories
      ], 200);
    } catch (Exception $error) {
      Log::error("errors", ["error" => $error->getMessage()]);

      return response()->json([
        "message" => $error->getMessage()
      ], $error->getCode());
    }
  }
}
