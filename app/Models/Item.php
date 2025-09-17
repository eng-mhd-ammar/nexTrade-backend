<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'desk_ar', 'name_en',
        'desk_en', 'count',
        'active', 'price',
        'discount', 'category_id',
        'image'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function userFavorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function userCarts()
    {
        return $this->belongsToMany(User::class, 'carts', 'item_id', 'user_id');
    }
}
