<?php

namespace Modules\Auth\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\Gender;
use Modules\Auth\Enums\UserType;
use Modules\Auth\Models\User;
use Modules\Core\Rules\ArrayOrMinusOne;
use Modules\Core\Rules\EnumRule;
use Modules\Core\Rules\FileOrUrl;

;
use Modules\Core\Rules\UniqueNotDeleted;

class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => [new FileOrUrl(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'heic', 'heif', 'svg'])],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'gender' => ['required', 'boolean', EnumRule::make(Gender::class)],
            // 'user_type_id' => ['exists:user_types,id', 'nullable', EnumRule::make(UserType::class)],
            'email' => ['required', 'string', 'email', new UniqueNotDeleted(User::class, 'email')],
            'password' => ['required', 'string', 'min:8', 'max:20'],

            'addresses' => [new ArrayOrMinusOne],
            'address.*.id' => ['required', 'exists:addresses,id'],
            'address.*.name' => ['required', 'string'],
            'address.*.city' => ['required', 'string'],
            'address.*.street' => ['required', 'string'],
            'address.*.phone' => ['required', 'string'],
            'address.*.location_lat' => ['required', 'numeric'],
            'address.*.location_long' => ['required', 'numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            // 'user_type_id' => $this->input('user_type_id', UserType::USER->value),
            'gender' => Gender::MALE->value,
        ]);
    }
}
