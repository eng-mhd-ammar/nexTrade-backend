<?php

namespace Modules\Address\Repositories\V1;

use Modules\Address\Interfaces\V1\Address\AddressRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Address\Models\Address;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    protected $model = Address::class;

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
