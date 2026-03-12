<?php

namespace Modules\Auth\Services\V1;

use Modules\Auth\Interfaces\V1\UserType\UserTypeServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Auth\Interfaces\V1\UserType\UserTypeRepositoryInterface;

class UserTypeService extends BaseService implements UserTypeServiceInterface
{
    public function __construct(protected UserTypeRepositoryInterface $repository)
    {
    }
}
