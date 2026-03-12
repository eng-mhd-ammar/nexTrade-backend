<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class ExistsOrMinusOne implements ValidationRule
{
    public function __construct(protected string $model, protected string $column = 'id')
    {
    }

    /**
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate($attribute, $value, $fail): void
    {
        if ($value == '-1') {
            return;
        }

        $exists = $this->model::query()->where($this->column, $value)->exists();

        if (! $exists) {
            $fail("The selected {$attribute} is invalid.");
        }
    }
}
