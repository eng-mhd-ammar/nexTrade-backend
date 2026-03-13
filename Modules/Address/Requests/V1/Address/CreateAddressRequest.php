<?php

namespace Modules\Address\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\AddressType;

class CreateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],

            'location_lat' => ['required', 'numeric', 'between:-90,90'],
            'location_long' => ['required', 'numeric', 'between:-180,180'],
        ];
    }
}
