<?php

namespace App;

use App\Http\Repositories\CacheRepository;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $sort
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
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
            CacheRepository::updateCategoriesCache();
        });
        static::updated(function () {
            CacheRepository::updateCategoriesCache();
        });
        static::deleted(function () {
            CacheRepository::updateCategoriesCache();
        });
        static::saved(function () {
            CacheRepository::updateCategoriesCache();
        });
    }
}
