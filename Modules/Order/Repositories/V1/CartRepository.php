<?php

namespace Modules\Order\Repositories\V1;

use Modules\Order\Interfaces\V1\Cart\CartRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Order\Models\Cart;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    protected $model = Cart::class;

    public function allowedFilters(): array
    {
        return [
            // AllowedFilter::exact('user_type', 'user_type_id'),
            // AllowedFilter::scope('search'),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            // AllowedInclude::relationship('favorites_items', 'favoritesItems'),
            // AllowedInclude::relationship('cart_items', 'cartItems'),
            // AllowedInclude::relationship('addresses'),
            // AllowedInclude::relationship('rates'),
            // AllowedInclude::relationship('orders'),
            // AllowedInclude::relationship('delivery_orders', 'deliveryOrders'),
            // AllowedInclude::relationship('notifications'),
            // AllowedInclude::relationship('user_type', 'type'),
        ];
    }
}
