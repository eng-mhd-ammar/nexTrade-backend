<?php

namespace Modules\Auth\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendResetPasswordLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required_without:phone', 'string', 'email'],
        ];
    }
}
