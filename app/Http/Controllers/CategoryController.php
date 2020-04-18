<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoriesCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CategoriesCollection
     */
    public function index()
    {
        return new CategoriesCollection(
            Category::all(Category::CATEGORY_FIELDS)->sortBy('sort')->values()
        );
    }
}
