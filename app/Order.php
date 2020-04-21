<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';

    const ORDER_FIELDS = [
        'id',
        'user_id',
        'email',
        'name',
        'address',
        'comment',
        'sum',
        'currency',
        'paid_delivery'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'address',
        'comment',
        'sum',
        'currency',
        'paid_delivery'
    ];

    /**
     * Get user of current order
     *
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     *  Get all order items related to current Order
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
