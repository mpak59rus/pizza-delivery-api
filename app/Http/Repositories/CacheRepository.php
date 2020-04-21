<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\Cache;

abstract class CacheRepository
{
    public static function updateCategoriesCache()
    {
        $key = env('CATEGORIES_CACHE_KEY', 'categories_cache_key');
        Cache::forget($key);
        Cache::forget($key . '_data');
        Cache::add($key, md5($key . time()));
    }

    public static function updateProductsCache()
    {
        $key = env('PRODUCTS_CACHE_KEY', 'products_cache_key');
        Cache::forget($key);
        Cache::forget($key . '_data');
        Cache::add($key, md5($key . time()));
    }
}
