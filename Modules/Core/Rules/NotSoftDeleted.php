<?php

namespace Modules\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NotSoftDeleted implements ValidationRule
{
    public function __construct(protected string $model, protected string $column = 'id')
    {
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }
        try {
            $this->model::where($this->column, $value)->first();
        } catch (ModelNotFoundException $e) {
            $fail("requested record has been deleted");
        }
    }
}
