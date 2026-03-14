<?php

namespace Modules\Product\Repositories\V1;

use Illuminate\Database\Eloquent\Builder;
use Modules\Product\Interfaces\V1\Stock\StockRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Product\Models\Stock;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class StockRepository extends BaseRepository implements StockRepositoryInterface
{
    protected $model = Stock::class;

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
