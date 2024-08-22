<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface StoryRepsoitoryInterface
{
  public function insert(array $data = []): ?Model;
  public function delete(int $id): bool;
  public function edit(array $data):bool;
  public function searchStories(string $keyword): ?Collection;

  public function getStoryById(int $id): ?Model;
  public function getStories(): Collection;
}
