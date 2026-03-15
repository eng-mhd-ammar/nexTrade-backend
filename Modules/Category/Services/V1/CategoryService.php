<?php

namespace Modules\Category\Services\V1;

use Modules\Category\Interfaces\V1\Category\CategoryServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Category\Interfaces\V1\Category\CategoryRepositoryInterface;
use Modules\Core\DTO\BaseDTO;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(protected CategoryRepositoryInterface $repository)
    {
    }
}
