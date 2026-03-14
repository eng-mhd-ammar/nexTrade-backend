<?php

namespace Modules\Product\Requests\V1\Product;

use Modules\Category\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\ProductType;
use Modules\Core\Rules\FileOrUrl;
use Modules\Core\Rules\NotSoftDeleted;
use Modules\Core\Rules\OneVideoAllowed;
use Modules\Product\Models\Stock;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_ar' => ['required', 'string', 'min:1', 'max:80'],
            'desc_ar' => ['required', 'string', 'min:1', 'max:255'],
            'name_en' => ['required', 'string', 'min:1', 'max:80'],
            'desc_en' => ['required', 'string', 'min:1', 'max:255'],
            'meta' => ['required', 'array'],
            'is_active' => ['boolean'],
            'note' => ['string', 'max:500'],
            'mpn' => ['string', 'regex:/^[a-zA-Z0-9\-\/\.]{6,30}$/'],
            'gtin' => ['string', 'regex:/^(?:\d{8}|\d{12}|\d{13}|\d{14})$/'],
            'oem' => ['string', 'regex:/^[A-Za-z0-9][A-Za-z0-9._\-\s\/]{0,49}$/'],
            'category_id' => ['exists:categories,id', 'required', 'string'/*, new NotSoftDeleted(Category::class)*/],

            'stocks' => ['required', 'array'],
            'stocks.*' => ['required', 'array'],
            'stocks.*.name_ar' => ['required', 'string', 'min:1', 'max:80'],
            'stocks.*.desc_ar' => ['required', 'string', 'min:1', 'max:255'],
            'stocks.*.name_en' => ['required', 'string', 'min:1', 'max:80'],
            'stocks.*.desc_en' => ['required', 'string', 'min:1', 'max:255'],
            'stocks.*.weight' => ['required', 'numeric', 'min:0'],
            'stocks.*.price' => ['required', 'numeric', 'min:0'],
            'stocks.*.sku' => ['string', 'regex:/^[a-zA-Z0-9\-_\.]{5,20}$/'],
            'stocks.*.quantity' => ['required', 'numeric', 'min:-1'],
            'stocks.*.images' => ['required', 'array', new OneVideoAllowed(['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', 'mpg', '3gp'])],
            'stocks.*.images.*' => ['required', new FileOrUrl(['jpg','jpeg','png','gif','bmp','tiff','tif','webp','heic','heif','svg','mp4','avi','mov','wmv','mkv','flv','webm','mpg','3gp'])],
            'stocks.*.attributes' => ['array'],
            'stocks.*.attributes.*.attributeGroup' => ['required', 'string'],
            'stocks.*.attributes.*.attributeName' => ['required', 'string'],
            'stocks.*.attributes.*.attributeValue' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => true,
        ]);
    }
}
