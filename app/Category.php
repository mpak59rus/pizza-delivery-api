<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    const CATEGORY_FIELDS = [
        'id',
        'title',
        'slug',
        'description'
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'sort'
    ];

    protected $cascadeDeletes = ['products'];

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     *  Get all products related to current Category
     *
     * @return HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function () {
            Category::updateCache();
        });
        static::updated(function () {
            Category::updateCache();
        });
        static::deleted(function () {
            Category::updateCache();
        });
        static::saved(function () {
            Category::updateCache();
        });
    }

    public static function updateCache() {
        $key = env('CATEGORIES_CACHE_KEY', 'categories_cache_key');
        Cache::forget($key);
        Cache::forget($key . '_data');
        Cache::add($key, md5($key . time()));
    }
}
