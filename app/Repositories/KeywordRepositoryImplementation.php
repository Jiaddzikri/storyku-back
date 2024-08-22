<?php

namespace App\Repositories;

use App\Models\Keywords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KeywordRepositoryImplementation implements KeywordRepositoryInterface
{
  public function __construct(private Keywords $keywords)
  {

  }

  public function insert(array $data = []): ?Model
  {
    $saved = null;

    DB::transaction(function() use ($data, &$saved) {
      $saved = $this->keywords->create($data);
    });

    return $saved;
  }

}