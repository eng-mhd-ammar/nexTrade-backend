<?php

namespace Modules\Favorite\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Enums\UserType;

class BoughtProduct implements ValidationRule
{

    public function validate($attribute, $value, $fail): void
    {
        // TODO: 
    }
}
