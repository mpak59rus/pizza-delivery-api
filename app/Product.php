<?php

namespace App;

use App\Http\Repositories\CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @property int $id
 * @property int $category_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property double $price_eur
 * @property double $price_usd
 * @property string $image_url
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
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
    public function category()
    {
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
            CacheRepository::updateProductsCache();
        });
        static::updated(function () {
            CacheRepository::updateProductsCache();
        });
        static::deleted(function () {
            CacheRepository::updateProductsCache();
        });
        static::saved(function () {
            CacheRepository::updateProductsCache();
        });
    }
}
