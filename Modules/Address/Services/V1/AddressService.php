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
}
