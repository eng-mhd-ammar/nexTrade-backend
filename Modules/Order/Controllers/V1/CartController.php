<?php

namespace Modules\Order\Controllers\V1;

use Modules\Order\DTO\V1\CartDTO;
use Modules\Order\Interfaces\V1\Cart\CartServiceInterface;
use Modules\Order\Resources\V1\CartResource;
use Modules\Order\Requests\V1\Cart\CreateCartRequest;
use Modules\Order\Requests\V1\Cart\UpdateCartRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class CartController extends BaseController
{
    public function __construct(protected CartServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(CartResource::collection($models)->resource))->success(message: "All Carts.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(CartResource::make($model)))->success(message: "Cart details.");
    }

    public function create(CreateCartRequest $request)
    {
        $this->modelService->create(CartDTO::fromRequest($request));
        return (new Response())->success(message: "Cart created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateCartRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, CartDTO::fromRequest($request));
        return (new Response())->success(message: "Cart updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Cart deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Cart force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Cart restored successfully.");
    }
}
