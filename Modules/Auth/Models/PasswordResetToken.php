<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Core\Observers\CRUDObserver;

#[ObservedBy(CRUDObserver::class)]
class PasswordResetToken extends Model
{
    use HasFactory;

    public static string $LOG_CHANNEL = 'password_reset_token';

    protected $fillable = [
        'email',
        'token',
    ];

    protected $casts = [
        'email' => 'string',
        'token' => 'string',
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class, 'email', 'email');
    }
}
