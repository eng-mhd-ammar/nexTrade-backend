<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Enums\UserType;

class ProhibitedUnlessHasRole implements ValidationRule
{
    public function __construct(protected Role|array $roles, protected $defaultValue = null)
    {
        $this->roles = is_array($roles) ? $roles : [$roles];
        $this->defaultValue = $defaultValue;
    }

    public function validate($attribute, $value, $fail): void
    {
        if ($value == null) {
            return;
        }
        if ($this->defaultValue == $value) {
            return;
        }


        $user = Auth::user();


        if (!$user) {
            $fail('User not authenticated.');
            return;
        }

        if (!in_array($user->role_id, $this->roles)) {
            $fail('User Does Not Have Permission.');
        }
    }
}
