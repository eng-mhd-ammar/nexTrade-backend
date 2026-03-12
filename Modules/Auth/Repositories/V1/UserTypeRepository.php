<?php

namespace Modules\Auth\Repositories\V1;

use Modules\Auth\Interfaces\V1\UserType\UserTypeRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Auth\Models\UserType;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class UserTypeRepository extends BaseRepository implements UserTypeRepositoryInterface
{
    protected $model = UserType::class;

    public function allowedFilters(): array
    {
        return [
            AllowedFilter::exact('user_type', 'id'),
            AllowedFilter::scope('search'),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('users'),
        ];
    }
}
