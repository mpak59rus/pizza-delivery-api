<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CacheService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $dataCacheKey = env('PRODUCTS_CACHE_KEY', 'products_cache_key') . '_data';

        return CacheService::remember($dataCacheKey, 24*60*60, function () {
            return Product::all(Product::PRODUCT_FIELDS)->sortBy('sort')->values();
        });
    }
}
