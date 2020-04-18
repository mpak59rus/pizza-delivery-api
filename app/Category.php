<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
