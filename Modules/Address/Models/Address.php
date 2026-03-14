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

    public static string $LOG_CHANNEL = 'address';

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

    public function scopeSearch(Builder $query, $value): Builder
    {
        $value = is_array($value) ? implode(',', $value) : $value;

        $search = strtolower(str_replace(' ', '', $value));

        return $query->where(function ($q) use ($search) {
            $q->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE ?", ["%{$search}%"])
                ->whereRaw("LOWER(REPLACE(country, ' ', '')) LIKE ?", ["%{$search}%"])
                ->whereRaw("LOWER(REPLACE(state, ' ', '')) LIKE ?", ["%{$search}%"])
                ->whereRaw("LOWER(REPLACE(city, ' ', '')) LIKE ?", ["%{$search}%"])
                ->whereRaw("LOWER(REPLACE(street, ' ', '')) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(REPLACE(phone, ' ', '')) LIKE ?", ["%{$search}%"]);
        });
    }
}






