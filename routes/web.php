<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;


Route::controller(CategoryController::class)->group(function() {
    Route::get("/api/categories", "getCategories");
});

Route::controller(StoryController::class)->group(function() {
    Route::post("/api/story", "store");
    Route::get("/api/stories", "getStories");
    Route::get("/api/story", "search");
});
