<?php

namespace Modules\Order\Services\V1;

use Modules\Order\Interfaces\V1\Cart\CartServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Order\Interfaces\V1\Cart\CartRepositoryInterface;
use Modules\Core\DTO\BaseDTO;

class CartService extends BaseService implements CartServiceInterface
{
    public function __construct(protected CartRepositoryInterface $repository)
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
