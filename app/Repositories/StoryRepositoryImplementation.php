<?php

namespace App\Repositories;

use App\Models\Stories;
use App\Repositories\StoryRepsoitoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoryRepositoryImplementation implements StoryRepsoitoryInterface
{

  public function __construct(private Stories $stories) {}
  public function getStories(): Collection
  {
    $stories = $this->stories->with(["categories:id,name", "chapters", "keywords"])->orderBy("created_at", "desc")->limit(5)->get();
    return $stories;
  }

  public function getStoryById(?int $id = null): ?Model
  {
    $stories = $this->stories->with(["categories", "chapters", "keywords"])->where("id", "=", $id)->first();

    return $stories;
  }

  public function searchStories(string $keyword): ?Collection
  {
    $stories = $this->stories->with(["categories", "chapters", "keywords"])->where(function($query) use ($keyword) {
      $query->where("title", "LIKE", "%" . $keyword . "%")
          ->orWhere("author", "LIKE", "%" . $keyword . "%");
    })->get();

    return $stories;
  }

  public function insert(array $data = []): ?Model
  {
    $saved = null;
    DB::transaction(function () use ($data, &$saved) {
      $saved = $this->stories->create($data);
    });

    return $saved;
  }

  public function delete(int $id): bool
  {
    $deleted = false;
    DB::transaction(function () use ($id, &$deleted) {
      $deleted =  $this->stories->where("id", "=", $id)->delete();
    });

    return $deleted;
  }

  public function edit(array $data = [], ?int $id = null): bool
  {
    $updated = false;
    DB::transaction(function () use ($data, $id, &$updated) {
      $updated = $this->stories->where("id", "=", $id)->update($data);
    });
    return $updated;
  }
}
