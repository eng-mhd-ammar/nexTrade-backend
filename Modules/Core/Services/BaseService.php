<?php

namespace Modules\Core\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\DTO\BaseDTO;
use Modules\Auth\Exceptions\AuthException;
use Modules\Core\Exceptions\PaginationException;

class BaseService
{
    public function all()
    {
        return $this->repository->all();
    }
    public function index()
    {
        $trashedFilter = request()->input('filter.trashed');

        if (Auth::check() && !Auth::user()->is_admin && in_array($trashedFilter, ['only', 'with'], true)) {
            return $this->throwNotAnAdmin();
        }

        $perPage = request()->query('pageSize', 10);
        if (!is_numeric($perPage)) {
            $perPage = 10;
        }
        $isPaginated = request()->query('paginated', true);
        if ($perPage < 1) {
            PaginationException::invalidPerPageProvided();
        }
        if ($isPaginated) {
            return $this->repository->paginate($perPage);
        }
        return $this->repository->all();
    }
    public function show(string $modelId)
    {
        return $this->repository->show($modelId);
    }
    public function create(BaseDTO $DTO)
    {
        return $this->repository->create($DTO->toArray());
    }
    public function update(string $modelId, BaseDTO $DTO)
    {
        return $this->repository->update($modelId, $DTO->filterNull()->toArray());
    }
    public function delete(string $modelId)
    {
        return $this->repository->delete($modelId);
    }
    public function deleteMany(array $ids)
    {
        return $this->repository->deleteMany($ids);
    }
    public function force_deleteMany(array $ids)
    {
        return $this->repository->force_deleteMany($ids);
    }
    public function restore_many(array $ids)
    {
        return $this->repository->restore_many($ids);
    }
    public function switchActivation(string $modelId)
    {
        return $this->repository->switchActivation($modelId);
    }

    public function addScopes(string|array $scopes)
    {
        $this->repository = $this->repository->addScopes($scopes);
        return $this;
    }

    public function with(string|array $relations)
    {
        $this->repository = $this->repository->with($relations);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC')
    {
        $this->repository = $this->repository->orderBy($column, $direction);
        return $this;
    }

    public function withExists(string|array $relations)
    {
        $this->repository = $this->repository->withExists($relations);
        return $this;
    }

    public function getRequestInstance(): Request
    {
        return request();
    }

    public function ForceDelete(string $modelId)
    {
        return $this->repository->ForceDelete($modelId);
    }

    public function restore($modelId)
    {
        return $this->repository->restore($modelId);
    }

    public function throwInvalidCredentials()
    {
        AuthException::invalidCredentials();
    }

    public function throwActivationException()
    {
        AuthException::accountHasBeenDeactivated();
    }
    public function throwUnverifiedAccount()
    {
        AuthException::unverifiedAccount();
    }

    public function throwInvalidOTP()
    {
        AuthException::invalidOtpProvided();
    }

    public function throwOtpTimeout()
    {
        AuthException::otpTimeout();
    }
    public function throwInvalidOldPassword()
    {
        AuthException::invalidOldPassword();
    }
    public function throwInvalidNewPassword()
    {
        AuthException::invalidNewPassword();
    }
    public function throwInvalidTokenProvided()
    {
        AuthException::invalidTokenProvided();
    }
    public function throwNotAnAdmin()
    {
        AuthException::notAnAdmin();
    }
}
