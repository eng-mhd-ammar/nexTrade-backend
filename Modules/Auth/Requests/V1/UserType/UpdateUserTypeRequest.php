<?php

namespace Modules\Auth\Requests\V1\UserType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string'],
        ];
    }
}
