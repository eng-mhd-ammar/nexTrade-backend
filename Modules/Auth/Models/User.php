<?php

namespace Modules\Auth\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\Models\Address;
use Modules\Auth\Enums\UserType as UserTypeEnum;
use Modules\Auth\Models\UserType;
use Modules\Core\Observers\CascadeSoftDeleteObserver;
use Modules\Core\Observers\CRUDObserver;
use Modules\Core\Observers\SyncFilesObserver;
use Modules\Favorite\Models\Favorite;
use Modules\Product\Models\Product;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

#[ObservedBy([CRUDObserver::class, CascadeSoftDeleteObserver::class, SyncFilesObserver::class])]
class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    public static string $LOG_CHANNEL = 'user';

    public array $cascadeDeletes = ['addresses'];

    public array $FilesFields = ['avatar'];

    protected $fillable = [
        'avatar',
        'first_name',
        'last_name',
        'gender',
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
        'gender' => \Modules\Auth\Enums\Gender::class,
    ];

    public function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole('admin'),
        );
    }

    public function isCustomer(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole('customer'),
        );
    }

    public function isDelivery(): Attribute
    {
        return new Attribute(
            get: fn () => $this->hasRole('delivery'),
        );
    }

    protected function name(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name . " " . $this->last_name,
        );
    }

    protected function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn () => $this->avatar ? asset($this->avatar) : "",
        );
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function favoritesItems()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }

    public function favorites() {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    // public function cartItems()
    // {
    //     return $this->belongsToMany(Item::class, 'carts');
    // }

    // public function rates()
    // {
    //     return $this->hasMany(Rate::class, 'user_id');
    // }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'user_id');
    // }

    // public function deliveryOrders()
    // {
    //     return $this->hasMany(Order::class, 'delivery_id');
    // }

    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class, 'user_id');
    // }

    public function type()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    public function scopeSearch(Builder $query, $value): Builder
    {
        $value = is_array($value) ? implode(',', $value) : $value;

        $search = strtolower(str_replace(' ', '', $value));

        return $query->where(function ($q) use ($search) {
            $q->whereRaw("LOWER(REPLACE(first_name, ' ', '')) LIKE ?", ["%{$search}%"])
                ->whereRaw("LOWER(REPLACE(last_name, ' ', '')) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("LOWER(REPLACE(email, ' ', '')) LIKE ?", ["%{$search}%"])
                ->orWhereRaw("CONCAT(LOWER(REPLACE(first_name, ' ', '')), LOWER(REPLACE(last_name, ' ', ''))) LIKE ?", ["%{$search}%"]);
        });
    }
}
