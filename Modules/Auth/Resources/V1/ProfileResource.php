<?php

namespace Modules\Auth\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Addresses\Resources\V1\AddressResource;
use Modules\Discounts\Resources\V1\CouponResource;
use Modules\Discounts\Resources\V1\DiscountResource;
use Modules\Notifications\Resources\V1\FcmTokenResource;
use Modules\Notifications\Resources\V1\NotificationResource;
use Modules\Orders\Resources\V1\OrderResource;
use Modules\Products\Resources\V1\FavoriteResource;
use Modules\Products\Resources\V1\ProductResource;
use Modules\Products\Resources\V1\RateResource;
use Modules\Stores\Resources\V1\StoreHelperResource;
use Modules\Stores\Resources\V1\StoreRateResource;
use Modules\Stores\Resources\V1\StoreResource;
use Modules\Tickets\Resources\V1\TicketMessageResource;
use Modules\Tickets\Resources\V1\TicketResource;

class ProfileResource extends JsonResource
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
            'email' => $this->email,

            // 'favorites_items' => FavoriteResource::collection($this->whenLoaded('favoritesItems')),
            // 'cart_items' => ProductResource::collection($this->whenLoaded('cartItems')),
            // 'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
            // 'rates' => RateResource::collection($this->whenLoaded('rates')),
            // 'orders' => OrderResource::collection($this->whenLoaded('orders')),
            // 'delivery_orders' => OrderResource::collection($this->whenLoaded('deliveryOrders')),
            // 'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
            'user_type' => new UserTypeResource($this->whenLoaded('type')),
        ];
    }
}
