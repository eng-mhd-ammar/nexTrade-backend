<?php

namespace Modules\Core\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SearchFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        $model = $query->getModel();

        if (method_exists($model, 'searchAs')) {
            $ids = $model::search($value)->keys();
            if (!empty($ids)) {
                $query->whereIn($model->qualifyColumn('id'), $ids);
            } else {
                $query->whereRaw('0 = 1');
            }
        }
    }
}
