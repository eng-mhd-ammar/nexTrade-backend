<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Observers\CascadeSoftDeleteObserver;
use Modules\Core\Observers\CRUDObserver;
use Modules\Core\Observers\SyncFilesObserver;
use Modules\Product\Models\Product;

#[ObservedBy([CRUDObserver::class, SyncFilesObserver::class, CascadeSoftDeleteObserver::class])]
class Category extends Model
{
    use HasFactory, SoftDeletes;

    public static string $LOG_CHANNEL = 'address';

    public array $fileFields = ['image'];

    public array $cascadeDeletes = ['products'];

    protected $table = 'categories';

    protected $fillable = [
        'name_en',
        'name_ar',
        'image',
        'category_id'
    ];

    public function imageUrl(): Attribute {
        return new Attribute(
            get: fn() => $this->image ? asset($this->image) : ""
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
