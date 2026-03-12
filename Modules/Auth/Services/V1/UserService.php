<?php

namespace Modules\Auth\Services\V1;

use Modules\Auth\Interfaces\V1\User\UserServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Auth\Interfaces\V1\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Enums\UserType;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    public function show(string $modelId)
    {
        return $this->repository->with('role')->show($modelId);
    }

    public function create($DTO)
    {
        $addresses = $DTO->addresses;

        $model = parent::create($DTO->filter(['addresses']));
        $model->markEmailAsVerified();

        if ($addresses) {
            $model->addresses()->createMany($addresses);
        }

        return $model;
    }

    public function update($model_id, $DTO)
    {
        $addresses = $DTO->addresses;
        $model = parent::update($model_id, $DTO->filter(['addresses']));
        $this->handleAddresses($addresses, $model);
        return $model;
    }

    private function handleAddresses($addresses, $model)
    {
        $addressIds = [];
        if (is_array($addresses)) {
            foreach ($addresses as $address) {
                $address = $model->addresses()->updateOrCreate(
                    ['id' => $address['id'] ?? null],
                    array_filter($address, fn ($value) => !is_null($value))
                );
                $addressIds[] = $address->id;
            }
        }
        $model->addresses()->whereNotIn('id', $addressIds)->forceDelete();
    }
}
