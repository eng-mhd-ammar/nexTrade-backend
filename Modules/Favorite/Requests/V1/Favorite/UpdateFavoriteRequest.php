<?php

namespace Modules\Favorite\Requests\V1\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\ProhibitedUnlessHasRole;
use Modules\Favorite\Rules\BoughtProduct;

class UpdateFavoriteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [new ProhibitedUnlessHasRole(['admin'])],
            'product_id' => ['required', new BoughtProduct],
        ];
    }
}
