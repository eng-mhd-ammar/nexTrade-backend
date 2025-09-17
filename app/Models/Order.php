<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'address_id',
        'type',
        'shipping',
        'price',
        'coupon_id',
        'total_price',
        'status',
        'delivery_id',
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class, 'order_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function deliveries()
    {
        return $this->belongsTo(User::class, 'delivery_id', 'id');
    }

    public function addresses()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

    public function rate()
    {
        return $this->hasOne(Rate::class, 'user_id');
    }
}
