<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface ChapterRepositoryInterface
{
  public function insert(array $data = []): ?Model;

  public function update(array $data, ?int $id = null):bool;
}
