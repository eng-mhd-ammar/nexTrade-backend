<?php

namespace Modules\Auth\Services\V1;

use Modules\Auth\Interfaces\V1\Profile\ProfileRepositoryInterface;
use Modules\Auth\Interfaces\V1\Profile\ProfileServiceInterface;
use Modules\Core\Services\BaseService;

class ProfileService extends BaseService implements ProfileServiceInterface
{
    public function __construct(protected ProfileRepositoryInterface $repository)
    {
    }

    public function show(string $modelId)
    {
        return $this->repository->with(['type'])->show($modelId);
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
            foreach ($addresses as $addressDTO) {
                $address = $model->addresses()->updateOrCreate(
                    ['id' => $addressDTO->id ?? null],
                    $addressDTO->filterNull()->toArray()
                );
                $addressIds[] = $address->id;
            }
        }
        $model->addresses()->whereNotIn('id', $addressIds)->forceDelete();
    }
}
