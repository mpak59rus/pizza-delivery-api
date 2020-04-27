<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $categoriesCacheKey = env('CATEGORIES_CACHE_KEY', 'categories_cache_key');
        $productsCacheKey = env('PRODUCTS_CACHE_KEY', 'products_cache_key');

        if (!Cache::has($categoriesCacheKey)) {
            CacheService::updateCategoriesCache();
        }

        if (!Cache::has($productsCacheKey)) {
            CacheService::updateProductsCache();
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
