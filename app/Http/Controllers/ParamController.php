<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Product;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index() {
        $categoriesCacheKey = env('CATEGORIES_CACHE_KEY', 'categories_cache_key');
        $productsCacheKey = env('PRODCUTS_CACHE_KEY', 'products_cache_key');
        if (!Cache::has($categoriesCacheKey)) {
            Category::updateCache();
        }
        if (!Cache::has($productsCacheKey)) {
            Product::updateCache();
        }
        $categoriesCache = Cache::get($categoriesCacheKey);
        $productsCache = Cache::get($productsCacheKey);

        return [
            'minsumEUR' => env('MIN_SUM_EUR', 15),
            'deliveryEUR' => env('DELIVERY_EUR', 3),
            'minsumUSD' => env('MIN_SUM_USD', 17),
            'deliveryUSD' => env('DELIVERY_USD', 4),
            'categoriesCache' => $categoriesCache,
            'productsCache' => $productsCache
        ];
    }
}
