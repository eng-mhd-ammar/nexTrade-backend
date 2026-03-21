<?php

namespace Modules\Favorite\Services\V1;

use Modules\Favorite\Interfaces\V1\Favorite\FavoriteServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Favorite\Interfaces\V1\Favorite\FavoriteRepositoryInterface;
use Modules\Core\DTO\BaseDTO;

class FavoriteService extends BaseService implements FavoriteServiceInterface
{
    public function __construct(protected FavoriteRepositoryInterface $repository)
    {
    }
}
