<?php

namespace Modules\Auth\Repositories\V1;

use Modules\Auth\Interfaces\V1\Profile\ProfileRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Auth\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    protected $model = User::class;

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('user_type', 'user_type_id'),
            AllowedFilter::scope('search'),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('favorites_items', 'favoritesItems'),
            AllowedInclude::relationship('cart_items', 'cartItems'),
            AllowedInclude::relationship('addresses'),
            AllowedInclude::relationship('rates'),
            AllowedInclude::relationship('orders'),
            AllowedInclude::relationship('delivery_orders', 'deliveryOrders'),
            AllowedInclude::relationship('notifications'),
            AllowedInclude::relationship('user_type', 'type'),
        ];
    }
}
