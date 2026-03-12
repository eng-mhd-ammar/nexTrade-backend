<?php

namespace Modules\Auth\Requests\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\UserType;
use Modules\Auth\Models\User;
use Modules\Core\Rules\ArrayOrMinusOne;
use Modules\Core\Rules\EnumRule;
use Modules\Core\Rules\UniqueNotDeleted;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'user_type_id' => ['exists:user_types,id', 'string', EnumRule::make(UserType::class)],
            'email' => ['string', 'email', new UniqueNotDeleted(User::class, 'email')],
            'password' => ['string', 'min:8', 'max:20'],

            'addresses' => ['array', new ArrayOrMinusOne],
            'address.*.id' => ['required', 'exists:addresses,id'],
            'address.*.name' => ['required', 'string'],
            'address.*.city' => ['required', 'string'],
            'address.*.street' => ['required', 'string'],
            'address.*.phone' => ['required', 'string'],
            'address.*.location_lat' => ['required', 'numeric'],
            'address.*.location_long' => ['required', 'numeric'],
        ];
    }
}
