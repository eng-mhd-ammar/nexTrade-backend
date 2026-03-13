<?php

namespace Modules\Address\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Resources\V1\UserResource;

class AddressResource extends JsonResource
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
            'name' => $this->name,
            'city' => $this->city,
            'street' => $this->street,
            'phone' => $this->phone,
            'location_lat' => $this->location_lat,
            'location_long' => $this->location_long,

            'user' => new UserResource($this->whenLoaded('user')),
            // 'orders' => OrderResource::collection($this->whenLoaded('orders')),
        ];
    }
}
