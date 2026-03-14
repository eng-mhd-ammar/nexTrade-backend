<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Observers\CascadeSoftDeleteObserver;
use Modules\Core\Observers\CRUDObserver;

#[ObservedBy([CRUDObserver::class, CascadeSoftDeleteObserver::class])]
class Product extends Model
{
    use HasFactory, SoftDeletes;

    public static string $LOG_CHANNEL = 'product';

    public array $cascadeDeletes = ['stocks'];

    protected $fillable = [
        'name_ar',
        'desc_ar',
        'name_en',
        'desc_en',
        'meta',
        'is_active',
        'mpn',
        'gtin',
        'oem',
        'note',
        'category_id',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_active' => 'boolean',
    ];

    // public function userFavorites()
    // {
    //     return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    // }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
