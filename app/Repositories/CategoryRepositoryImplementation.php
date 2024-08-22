<?php

namespace App\Repositories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepositoryImplementation implements CategoryRepositoryInterface
{
  public function __construct(private Categories $categories) {}
  public function getCategories(): Collection
  {
    $categories = $this->categories->get();
    return $categories;
  }
}
