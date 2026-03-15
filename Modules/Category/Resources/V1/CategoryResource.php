<?php

namespace Modules\Category\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Resources\V1\UserResource;
use Modules\Product\Resources\V1\ProductResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'image' => $this->image_url,

            'parent_category' => new CategoryResource($this->whenLoaded('parentCategory')),
            'children_categories' => CategoryResource::collection($this->whenLoaded('childrenCategories')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
