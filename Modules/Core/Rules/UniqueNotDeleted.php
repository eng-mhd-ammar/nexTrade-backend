<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class UniqueNotDeleted implements ValidationRule
{
    public function __construct(protected string $model, protected string|array $columns, protected ?string $ignoreId = null)
    {
    }

    public function validate($attribute, $value, $fail): void
    {
        $query = $this->model::query()->whereNull('deleted_at');

        if (is_string($this->columns)) {
            // عمود واحد
            $query->where($this->columns, $value);
        } elseif (is_array($this->columns)) {
            // مصفوفة أعمدة => قيم
            foreach ($this->columns as $column => $columnValue) {
                $query->where($column, $columnValue);
            }
        }

        if ($this->ignoreId !== null) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail("The {$attribute} has already been taken (active record exists).");
        }
    }
}
