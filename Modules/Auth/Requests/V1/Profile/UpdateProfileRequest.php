<?php

namespace Modules\Auth\Requests\V1\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Addresses\Models\State;
use Modules\Auth\Enums\Gender;
use Modules\Auth\Enums\UserType;
use Modules\Auth\Models\User;
use Modules\Core\Rules\ArrayOrMinusOne;
use Modules\Core\Rules\EnumRule;
use Modules\Core\Rules\FileOrUrl;
use Modules\Core\Rules\NotSoftDeleted;
use Modules\Core\Rules\UniqueNotDeleted;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
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
