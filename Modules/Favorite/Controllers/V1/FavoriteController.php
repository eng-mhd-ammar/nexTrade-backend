<?php

namespace Modules\Favorite\Controllers\V1;

use Modules\Favorite\DTO\V1\FavoriteDTO;
use Modules\Favorite\Interfaces\V1\Favorite\FavoriteServiceInterface;
use Modules\Favorite\Resources\V1\FavoriteResource;
use Modules\Favorite\Requests\V1\Favorite\CreateFavoriteRequest;
use Modules\Favorite\Requests\V1\Favorite\UpdateFavoriteRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Utilities\Response;

class FavoriteController extends BaseController
{
    public function __construct(protected FavoriteServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(FavoriteResource::collection($models)->resource))->success(message: "All favorites.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(FavoriteResource::make($model)))->success(message: "Favorite details.");
    }

    public function create(CreateFavoriteRequest $request)
    {
        $this->modelService->create(FavoriteDTO::fromRequest($request));
        return (new Response())->success(message: "Favorite created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateFavoriteRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, FavoriteDTO::fromRequest($request));
        return (new Response())->success(message: "Favorite updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Favorite deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Favorite force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Favorite restored successfully.");
    }
}
