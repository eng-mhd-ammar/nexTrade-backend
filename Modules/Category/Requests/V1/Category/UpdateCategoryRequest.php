<?php

namespace Modules\Category\Requests\V1\Category;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Rules\FileOrUrl;

class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_en' => ['string', 'max:255'],
            'name_ar' => ['string', 'max:255'],
            'image' => [new FileOrUrl(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'heic', 'heif', 'svg'])],
            'category_id' => ['nullable', new NotSoftDeleted(Category::class)],
        ];
    }
}
