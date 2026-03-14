<?php

namespace Modules\Product\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Resources\V1\UserResource;

class ProductResource extends JsonResource
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
            'meta' => $this->meta,
            'count' => $this->count,
            'is_active' => $this->is_active,
            'mpn' => $this->mpn,
            'gtin' => $this->gtin,
            'oem' => $this->oem,
            'note' => $this->note,

            'stocks' => StockResource::collection($this->whenLoaded('stocks')),
            // 'user' => new UserResource($this->whenLoaded('user')),
            // 'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
