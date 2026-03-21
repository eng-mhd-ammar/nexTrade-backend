<?php

namespace Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string', 'min:8', 'max:20'],
            'new_password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ];
    }
}
