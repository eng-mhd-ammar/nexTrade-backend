<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class ArrayOrMinusOne implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($value)) {
            return;
        }

        if ($value === -1) {
            return;
        }

        if (is_array($value)) {
            return;
        }

        $fail("The {$attribute} must be an array or -1.");
    }
}
