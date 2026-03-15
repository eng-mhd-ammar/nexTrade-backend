<?php

namespace Modules\Product\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// use Modules\Category\Resources\V1\CategoryResource;

class StockResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'desc_ar' => $this->desc_ar,
            'name_en' => $this->name_en,
            'desc_en' => $this->desc_en,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'weight' => $this->weight,
            'sku' => $this->sku,
            'images' => $this->images_urls,
            'attributes' => $this->attributes,

            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
