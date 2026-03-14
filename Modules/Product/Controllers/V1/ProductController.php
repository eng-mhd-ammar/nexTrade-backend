<?php

namespace Modules\Product\Controllers\V1;

use Modules\Product\DTO\V1\ProductDTO;
use Modules\Product\Interfaces\V1\Product\ProductServiceInterface;
use Modules\Product\Resources\V1\ProductResource;
use Modules\Product\Requests\V1\Product\CreateProductRequest;
use Modules\Product\Requests\V1\Product\UpdateProductRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class ProductController extends BaseController
{
    public function __construct(protected ProductServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(ProductResource::collection($models)->resource))->success(message: "All products.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(ProductResource::make($model)))->success(message: "Product details.");
    }

    public function create(CreateProductRequest $request)
    {
        $this->modelService->create(ProductDTO::fromRequest($request));
        return (new Response())->success(message: "Product created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateProductRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, ProductDTO::fromRequest($request));
        return (new Response())->success(message: "Product updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Product deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Product force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Product restored successfully.");
    }
}
