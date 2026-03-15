<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;
use Modules\Category\Models\Category;
use Modules\Core\Observers\CRUDObserver;
use Modules\Core\Observers\SyncFilesObserver;

#[ObservedBy([CRUDObserver::class, SyncFilesObserver::class])]
class Stock extends Model
{
    use HasFactory, SoftDeletes;

    public static string $LOG_CHANNEL = 'stock';

    public array $fileFields = ['images'];

    protected $fillable = [
        'name_ar',
        'desc_ar',
        'name_en',
        'desc_en',
        'price',
        'quantity',
        'weight',
        'sku',
        'images',
        'attributes',
        'product_id',
    ];

    protected $casts = [
        'images' => 'array',
        'attributes' => 'array',
    ];

    public function isUnlimited() {
        return new Attribute (
            get: fn() => $this->quantity == -1
        );
    }

    protected function imagesUrls(): Attribute
    {
        return new Attribute(
            get: fn () => array_map(function ($image) { return asset($image); }, $this->images),
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // public function userFavorites()
    // {
    //     return $this->belongsToMany(User::class, 'favorites', 'stock_id', 'user_id');
    // }

    public function carts()
    {
        return $this->belongsToMany(User::class, 'carts', 'stock_id', 'user_id');
    }
}
