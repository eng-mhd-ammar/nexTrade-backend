<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnumRule implements Rule
{
    private string $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public static function make(string $enum): self
    {
        return new self($enum);
    }

    public function passes($attribute, $value): bool
    {
        $enumValues = array_map(fn ($case) => $case->value, $this->enum::cases());
        return in_array((int) $value, $enumValues, true);
    }



    public function message(): string
    {
        return 'The selected :attribute is invalid.';
    }
}
