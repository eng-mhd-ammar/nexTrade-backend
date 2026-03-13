<?php

namespace Modules\Address\Services\V1;

use Modules\Address\Interfaces\V1\Address\AddressServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Address\Interfaces\V1\Address\AddressRepositoryInterface;
use Modules\Core\DTO\BaseDTO;

class AddressService extends BaseService implements AddressServiceInterface
{
    public function __construct(protected AddressRepositoryInterface $repository)
    {
    }

    public function index()
    {
        $this->repository = $this->repository->where('user_id', auth()->id());
        return parent::index();
    }

    public function create($DTO)
    {
        $DTO->user_id = auth()->id();
        return parent::create($DTO);
    }
}
