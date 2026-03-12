<?php

namespace Modules\Core\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteManyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids' => ['array', 'required'],
            'ids.*' => ['required', 'string'],
        ];
    }
}
