<?php

namespace Modules\Address\Repositories\V1;

use Illuminate\Database\Eloquent\Builder;
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
