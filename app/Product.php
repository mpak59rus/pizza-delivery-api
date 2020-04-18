<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
