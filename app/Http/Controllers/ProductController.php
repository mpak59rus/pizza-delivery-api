<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductsCollection;
use App\Models\Product;
use App\Services\CacheService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductsCollection
     */
    public function index()
    {
        $dataCacheKey = env('PRODUCTS_CACHE_KEY', 'products_cache_key') . '_data';

        return CacheService::remember($dataCacheKey, 24*60*60, function () {
            return new ProductsCollection(
                Product::all(Product::PRODUCT_FIELDS)->sortBy('sort')->values()
            );
        });
    }
}
