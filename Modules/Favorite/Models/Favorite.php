<?php

namespace Modules\Favorite\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;
use Modules\Core\Observers\CRUDObserver;
use Modules\Product\Models\Product;

#[ObservedBy([CRUDObserver::class])]
class Favorite extends Model
{
    use HasFactory, SoftDeletes;

    public static string $LOG_CHANNEL = "favorite";

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    public function product() {
        $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user() {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
