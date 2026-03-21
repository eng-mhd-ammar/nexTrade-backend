<?php

namespace Modules\Favorite\Requests\V1\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\ProhibitedUnlessHasRole;
use Modules\Favorite\Rules\BoughtProduct;

class CreateFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [new ProhibitedUnlessHasRole(['admin'])],
            'product_id' => ['required', new BoughtProduct],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}
