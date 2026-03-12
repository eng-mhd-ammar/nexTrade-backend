<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ObjectOrMinusOne implements ValidationRule
{
    /**
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate($attribute, $value, $fail): void
    {
        if ($value == -1 || is_null($value)) {
            return;
        }

        // foreach ($value as $item) {
        if (!is_array($value)) {
            $fail("The {$attribute} must be -1 or an array of objects.");
            return;
        }
        // }
    }
}
