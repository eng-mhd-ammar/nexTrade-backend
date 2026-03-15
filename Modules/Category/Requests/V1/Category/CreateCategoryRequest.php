<?php

namespace Modules\Category\Requests\V1\Category;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\CategoryType;
use Modules\Category\Models\Category;
use Modules\Core\Rules\FileOrUrl;
use Modules\Core\Rules\NotSoftDeleted;

class CreateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'image' => ['required', new FileOrUrl(['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'tif', 'webp', 'heic', 'heif', 'svg'])],
            'category_id' => ['nullable', new NotSoftDeleted(Category::class)],
        ];
    }
}
