<?php

namespace Modules\Address\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'street' => ['string', 'max:255'],
            'phone' => ['string', 'max:20'],

            'location_lat' => ['numeric', 'between:-90,90'],
            'location_long' => ['numeric', 'between:-180,180'],
        ];
    }
}
