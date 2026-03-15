<?php

namespace Modules\Category\Controllers\V1;

use Modules\Category\DTO\V1\CategoryDTO;
use Modules\Category\Interfaces\V1\Category\CategoryServiceInterface;
use Modules\Category\Resources\V1\CategoryResource;
use Modules\Category\Requests\V1\Category\CreateCategoryRequest;
use Modules\Category\Requests\V1\Category\UpdateCategoryRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(CategoryResource::collection($models)->resource))->success(message: "All categories.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(CategoryResource::make($model)))->success(message: "Category details.");
    }

    public function create(CreateCategoryRequest $request)
    {
        $this->modelService->create(CategoryDTO::fromRequest($request));
        return (new Response())->success(message: "Category created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateCategoryRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, CategoryDTO::fromRequest($request));
        return (new Response())->success(message: "Category updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Category deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Category force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Category restored successfully.");
    }
}
