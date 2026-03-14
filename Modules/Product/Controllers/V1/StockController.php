<?php

namespace Modules\Product\Controllers\V1;

use Modules\Product\DTO\V1\StockDTO;
use Modules\Product\Interfaces\V1\Stock\StockServiceInterface;
use Modules\Product\Resources\V1\StockResource;
use Modules\Product\Requests\V1\Stock\CreateStockRequest;
use Modules\Product\Requests\V1\Stock\UpdateStockRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class StockController extends BaseController
{
    public function __construct(protected StockServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(StockResource::collection($models)->resource))->success(message: "All stocks.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(StockResource::make($model)))->success(message: "Stock details.");
    }

    public function create(CreateStockRequest $request)
    {
        $this->modelService->create(StockDTO::fromRequest($request));
        return (new Response())->success(message: "Stock created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateStockRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, StockDTO::fromRequest($request));
        return (new Response())->success(message: "Stock updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Stock deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Stock force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Stock restored successfully.");
    }
}
