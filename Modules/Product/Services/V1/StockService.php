<?php

namespace Modules\Product\Services\V1;

use Modules\Product\Interfaces\V1\Stock\StockServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Product\Interfaces\V1\Stock\StockRepositoryInterface;
use Modules\Core\DTO\BaseDTO;

class StockService extends BaseService implements StockServiceInterface
{
    public function __construct(protected StockRepositoryInterface $repository)
    {
    }

    public function create($DTO)
    {
        $stock = parent::create($DTO);

        // if (!is_null($DTO->coupons)) {
        //     $stock->coupons()->sync($DTO->coupons);
        // }

        // if (!is_null($DTO->discounts)) {
        //     $stock->discounts()->sync($DTO->discounts);
        // }

        return $stock;
    }

    public function update($modelId, $DTO)
    {
        $stock = $this->repository->show($modelId);

        // $coupons = $DTO->coupons;
        // $discounts = $DTO->discounts;

        $stock = parent::update($modelId, $DTO);

        // if (!is_null($coupons)) {
        //     $stock->coupons()->sync($DTO->coupons);
        // }

        // if (!is_null($discounts)) {
        //     $stock->discounts()->sync($DTO->discounts);
        // }

        return $stock;
    }
}
