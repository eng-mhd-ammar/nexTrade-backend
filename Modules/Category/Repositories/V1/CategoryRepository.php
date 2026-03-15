<?php

namespace Modules\Category\Repositories\V1;

use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Interfaces\V1\Category\CategoryRepositoryInterface;
use Modules\Core\Repositories\BaseRepository;
use Modules\Category\Models\Category;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;

    public function allowedFilters(): array
    {
        return [
            // AllowedFilter::exact('user', 'user_id'),
            // AllowedFilter::scope('search'),
        ];
    }

    public function allowedIncludes(): array
    {
        return [
            // AllowedInclude::relationship('user'),
        ];
    }
}
