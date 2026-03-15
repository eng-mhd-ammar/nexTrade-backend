<?php

namespace Modules\Category\DTO\V1;

use Modules\Category\Requests\V1\Category\CreateCategoryRequest;
use Modules\Category\Requests\V1\Category\UpdateCategoryRequest;
use Modules\Core\DTO\BaseDTO;

class CategoryDTO extends BaseDTO
{
    public function __construct(
        public ?string $name_en,
        public ?string $name_ar,
        public ?string $image,
        public ?string $category_id,
    ) {
    }

    public static function fromRequest(CreateCategoryRequest|UpdateCategoryRequest $request): self
    {
        return new self(
            name_en: $request->validated('name_en'),
            name_ar: $request->validated('name_ar'),
            image: self::handleFileStoring($request->validated('image'), '/categories'),
            category_id: $request->validated('category_id'),
        );
    }
}
