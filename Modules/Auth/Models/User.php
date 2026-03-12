<?php

namespace Modules\Auth\Models;

use App\Models\Address;
use App\Models\Item;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Rate;
use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Core\Observers\CRUDObserver;

#[ObservedBy([CRUDObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected string $logChannel = 'user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'email_verified_at',
        'user_type_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_type_id' => \Modules\Auth\Enums\UserType::class,
    ];

    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => Auth::check() && $this->role_id == UserType::ADMIN,
        );
    }

    protected function isCustomer(): Attribute
    {
        return new Attribute(
            get: fn () => Auth::check() && $this->role_id == UserType::USER,
        );
    }

    protected function isDelivery(): Attribute
    {
        return new Attribute(
            get: fn () => Auth::check() && $this->role_id == UserType::DELIVERY,
        );
    }

    public function favoritesItems()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }

    public function cartItems()
    {
        return $this->belongsToMany(Item::class, 'carts');
    }

    public function rates()
    {
        return $this->hasMany(Rate::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function deliveryOrders()
    {
        return $this->hasMany(Order::class, 'delivery_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function scopeSearch(Builder $query, $value): Builder
    {
        $value = is_array($value) ? implode(',', $value) : $value;

        $search = strtolower(str_replace(' ', '', $value));

        return $query->where(function ($q) use ($search) {
            $q->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(REPLACE(email, ' ', '')) LIKE ?", ["%{$search}%"]);
        });
    }
}
