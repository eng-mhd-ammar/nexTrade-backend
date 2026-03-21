<?php

namespace Modules\Address\Requests\V1\Address;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\ProhibitedUnlessHasRole;

class UpdateAddressRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['string', new ProhibitedUnlessHasRole(['admin'])],
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
