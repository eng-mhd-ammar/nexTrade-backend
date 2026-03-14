<?php

namespace Modules\Order\Requests\V1\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\CartType;

class CreateCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'details' => ['string', 'min:3', 'max:5000'],
        ];
    }
}
