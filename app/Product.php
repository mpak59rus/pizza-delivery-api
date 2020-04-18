<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use SoftDeletes;

    const PRODUCT_FIELDS = [
        'id',
        'category_id',
        'title',
        'slug',
        'description',
        'price_eur',
        'price_usd',
        'image_url'
    ];

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'price_eur',
        'price_usd',
        'image_url',
        'sort'
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get menu category of current product
     *
     * @return BelongsTo
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function () {
            Product::updateCache();
        });
        static::updated(function () {
            Product::updateCache();
        });
        static::deleted(function () {
            Product::updateCache();
        });
        static::saved(function () {
            Product::updateCache();
        });
    }

    public static function updateCache() {
        $key = env('PRODCUTS_CACHE_KEY', 'products_cache_key');
        Cache::forget($key);
        Cache::forget($key . '_data');
        Cache::add($key, md5($key . time()));
    }
}
