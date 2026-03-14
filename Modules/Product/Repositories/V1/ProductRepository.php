<?php

namespace Modules\Product\Repositories\V1;

use Illuminate\Database\Eloquent\Builder;
use Modules\Product\Interfaces\V1\Product\ProductRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Product\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model = Product::class;

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('user', 'user_id'),
            AllowedFilter::scope('search'),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('user'),
        ];
    }
}
