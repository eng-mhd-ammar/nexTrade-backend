<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => Auth::check() && $this->role_id == RoleEnum::ADMIN,
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
    }?->id

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
}
