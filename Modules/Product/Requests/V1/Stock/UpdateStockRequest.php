<?php

namespace Modules\Product\Requests\V1\Stock;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\FileOrUrl;
use Modules\Core\Rules\NotSoftDeleted;
use Modules\Core\Rules\OneVideoAllowed;
use Modules\Product\Models\Product;

class UpdateStockRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ar' => ['string', 'min:1', 'max:80'],
            'desc_ar' => ['string', 'min:1', 'max:255'],
            'name_en' => ['string', 'min:1', 'max:80'],
            'desc_en' => ['string', 'min:1', 'max:255'],
            'weight' => ['numeric', 'min:0'],
            'price' => ['numeric', 'min:0'],
            'sku' => ['string', 'regex:/^[a-zA-Z0-9\-_\.]{5,20}$/'],
            'quantity' => ['numeric', 'min:-1'],
            'product_id' => ['string', 'uuid', 'exists:products,id', new NotSoftDeleted(Product::class)],

            'images' => ['array', new OneVideoAllowed('mp4, avi, mov, wmv, mkv, flv, webm, mpg, 3gp')],
            'images.*' => ['required', new FileOrUrl('jpg, jpeg, png, gif, bmp, tiff, tif, webp, heic, heif, svg, mp4, avi, mov, wmv, mkv, flv, webm, mpg, 3gp')],

            'attributes' => ['array'],
            'attributes.*.attributeGroup' => ['required', 'string'],
            'attributes.*.attributeName' => ['required', 'string'],
            'attributes.*.attributeValue' => ['required', 'string'],
        ];
    }
}
