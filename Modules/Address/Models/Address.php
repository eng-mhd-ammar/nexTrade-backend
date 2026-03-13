<?php

namespace Modules\Address\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Models\User;
use Modules\Core\Observers\CRUDObserver;

#[ObservedBy([CRUDObserver::class])]
class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected string $logChannel = 'address';

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'name',
        'country',
        'state',
        'city',
        'street',
        'phone',
        'coordinates',
        'details',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'order_id');
    // }
}
