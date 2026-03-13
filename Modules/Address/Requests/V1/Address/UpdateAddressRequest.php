<?php

namespace Modules\Address\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'state' => ['string', 'max:255'],
            'country' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'street' => ['string', 'max:255'],
            'phone' => ['string', 'max:20'],
            'lat' => ['required_with:lng', 'numeric', 'between:-90,90'],
            'lng' => ['required_with:lat', 'numeric', 'between:-180,180'],
            'details' => ['string', 'min:3', 'max:5000'],
        ];
    }
}
