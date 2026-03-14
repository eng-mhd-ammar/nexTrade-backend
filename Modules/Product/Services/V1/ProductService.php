<?php

namespace Modules\Product\Services\V1;

use Modules\Product\Interfaces\V1\Product\ProductServiceInterface;
use Modules\Core\Services\BaseService;
use Modules\Product\Interfaces\V1\Product\ProductRepositoryInterface;
use Modules\Core\DTO\BaseDTO;
use Modules\Product\Interfaces\V1\Stock\StockServiceInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $repository)
    {
    }

    public function create($DTO)
    {
        // dd($DTO);
        $product = parent::create($DTO);

        foreach ($DTO->stocks as $stockData) {
            $stockData->product_id = $product->id;
            $stock_service = app(StockServiceInterface::class);
            $stock_service->create($stockData);
        }

        // if (!is_null($DTO->coupons)) {
        //     $product->coupons()->sync($DTO->coupons);
        // }

        // if (!is_null($DTO->discounts)) {
        //     $product->discounts()->sync($DTO->discounts);
        // }

        return $product;
    }

    public function update($modelId, $DTO)
    {
        $model = $this->repository->show($modelId);

        if ($DTO->stocks) {
            foreach ($DTO->stocks as $stock) {
                $stock->product_id = $model->id;
                $stock_service = app(StockServiceInterface::class);
                if (isset($stock->id)) {
                    $data = $stock_service->update($stock->id, $stock->filter(['id']));
                } else {
                    $data = $stock_service->create($stock->filter(['id']));
                }
                $stockIds[] = $data->id;
            }
            $model->stocks()->whereNotIn('id', $stockIds)->delete();
        }

        // if (!is_null($DTO->coupons)) {
        //     $model->coupons()->sync($DTO->coupons);
        // }


        // if (!is_null($DTO->discounts)) {
        //     $model->discounts()->sync($DTO->discounts);
        // }

        return $this->repository->update($modelId, $DTO->filter(['stocks'])->filterNull()->toArray());
    }
}
