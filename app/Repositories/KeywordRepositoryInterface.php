<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface KeywordRepositoryInterface
{
  public function insert(array $data = []): ?Model;
 
}