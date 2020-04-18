<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoriesCollection;
use Illuminate\Support\Facades\Cache;

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
        return Cache::remember($dataCacheKey, 24*60*60, function () {
            return new CategoriesCollection(
                Category::all(Category::CATEGORY_FIELDS)->sortBy('sort')->values()
            );
        });
    }
}
