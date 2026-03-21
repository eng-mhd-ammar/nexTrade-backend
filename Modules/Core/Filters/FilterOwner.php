<?php

namespace Modules\Core\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Exceptions\AuthException;

class FilterOwner implements Filter
{
    protected array $columns;

    public function __construct(string|array $columns = 'user_id')
    {
        $this->columns = is_array($columns) ? $columns : [$columns];
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $user = auth()->user();

        if (is_string($value)) {
            $value = [$value];
        }

        if (in_array('1', $value)) {
            if (!$user->is_admin) {
                throw AuthException::notAnAdmin();
            }

            return $query;
        }

        return $query->where(function ($q) use ($user) {
            foreach ($this->columns as $index => $column) {
                if ($index === 0) {
                    $q->where($column, $user->id);
                } else {
                    $q->orWhere($column, $user->id);
                }
            }
        });
    }
}
