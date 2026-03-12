<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Observers\CRUDObserver;

#[ObservedBy([CRUDObserver::class])]
class UserType extends Model
{
    use HasFactory, SoftDeletes;

    protected string $logChannel = 'user-type';

    protected $fillable = [
        'name',
        'type',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_type_id');
    }

    public function scopeSearch(Builder $query, $value): Builder
    {
        $value = is_array($value) ? implode(',', $value) : $value;

        $search = strtolower(str_replace(' ', '', $value));

        return $query->where(function ($q) use ($search) {
            $q->whereRaw("LOWER(REPLACE(name, ' ', '')) LIKE ?", ["%{$search}%"]);
        });
    }
}
