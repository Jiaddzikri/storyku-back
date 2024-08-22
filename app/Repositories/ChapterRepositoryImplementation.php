<?php

namespace App\Repositories;

use App\Models\Chapters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChapterRepositoryImplementation implements ChapterRepositoryInterface
{
  public function __construct(private Chapters $chapters){}
  public function insert(array $data = []): ?Model 
  {
    $saved = null;

    DB::transaction(function() use ($data, &$saved) {
      $saved = $this->chapters->create($data);
    });

    return $saved;
  }

  public function update(array $data, ?int $id = null): bool
  {
    $updated = false;

    DB::transaction(function() use ($data, $id, &$updated) {
      $updated = $this->chapters->where("id", "=", $id)->update($data);
    });
    return $updated;
  }

  public function delete(?int $id): bool
  {
    $deleted = false;
    DB::transaction(function() use ($id, &$deleted)  {
      $deleted = $this->chapters->where("id", "=", $id)->delete();
    });

    return $deleted;
  }
}
