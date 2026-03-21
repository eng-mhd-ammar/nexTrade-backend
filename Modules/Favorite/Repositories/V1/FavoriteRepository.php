<?php

namespace Modules\Favorite\Repositories\V1;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filters\FilterOwner;
use Modules\Favorite\Interfaces\V1\Favorite\FavoriteRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Favorite\Models\Favorite;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    protected $model = Favorite::class;

    public function allowedFilters(): array
    {

        return [
            AllowedFilter::exact('user', 'user_id'),
            AllowedFilter::exact('product', 'product_id'),
            AllowedFilter::custom('all', new FilterOwner('user_id'))->default([0]),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('user'),
            AllowedInclude::relationship('product'),
        ];
    }
}
