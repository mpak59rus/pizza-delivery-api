<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    const ORDER_ITEM_FIELDS = [
        'id',
        'order_id',
        'product_id',
        'quantity',
        'sort'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'sort'
    ];

    /**
     * Get order
     *
     * @return BelongsTo
     */
    public function order(){
        return $this->belongsTo(Order::class);
    }

    /**
     * Get product
     *
     * @return BelongsTo
     */
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
