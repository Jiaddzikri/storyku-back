<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepositoryImplementation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function __construct(private CategoryRepositoryImplementation $categoryRepositoryImplememntation) {}

    public function getCategories(): JsonResponse
    {
        Log::info("start fetching categories data");
        $categories = $this->categoryRepositoryImplememntation->getCategories();

        try {
            if (sizeof($categories) == 0) throw new Exception(json_encode(["category" => "categories not found"]), 404);
            Log::info("categories found", ["categories" => $categories]);
            return response()->json([
                "data" => $categories
            ], 200);
        } catch (Exception $error) {
            Log::error("errors", ["message" => $error->getMessage()]);
            return response()->json([
                "message" => json_decode($error->getMessage())
            ], $error->getCode());
        }
    }
}
