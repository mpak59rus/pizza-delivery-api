<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesCollection;
use App\Models\Category;
use App\Services\CacheService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoriesCollection
     */
    public function index()
    {
        $dataCacheKey = env('CATEGORIES_CACHE_KEY', 'categories_cache_key') . '_data';

        return CacheService::remember($dataCacheKey, 24 * 60 * 60, function () {
            return new CategoriesCollection(Category::all(Category::CATEGORY_FIELDS)
                ->filter(function (Category $category) {
                    return $category->products()->count() > 0 ? true : false;
                })->sortBy('sort')->values());
        });
    }
}
