<?php

namespace Modules\Auth\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required_without:phone', 'string', 'email'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:20'],
            'token' => ['required','string'],
        ];
    }
}
