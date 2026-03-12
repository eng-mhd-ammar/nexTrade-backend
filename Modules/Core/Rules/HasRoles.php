<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Auth\Models\User;

class HasRoles implements ValidationRule
{
    public function __construct(protected array|string $roles = [])
    {
        $this->roles = is_array($roles)
            ? $roles
            : explode(',', str_replace(' ', '', $roles));
    }

    /**
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate($attribute, $value, $fail): void
    {
        if(!$value) return;
        $user = User::findOrFail($value);

        if(in_array($user->role_id, $this->roles)) {
            return;
        }

        $fail("Invalid User Role: $user->full_name.");
    }
}
