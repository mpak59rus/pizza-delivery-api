<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

abstract class CacheService
{
    public static function updateCategoriesCache()
    {
        $key = env('CATEGORIES_CACHE_KEY', 'categories_cache_key');
        self::addCache($key);
    }

    public static function updateProductsCache()
    {
        $key = env('PRODUCTS_CACHE_KEY', 'products_cache_key');
        self::addCache($key);
    }

    private static function addCache($key)
    {
        Cache::forget($key);
        Cache::forget($key . '_data');
        Cache::add($key, md5($key . time()));
    }

    public static function remember(string $key, int $ttl, \Closure $callback)
    {
        return Cache::remember($key, $ttl, $callback);
    }
}
