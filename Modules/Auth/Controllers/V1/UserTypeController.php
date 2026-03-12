<?php

namespace Modules\Auth\Controllers\V1;

use Modules\Auth\DTO\V1\UserTypeDTO;
use Modules\Auth\Interfaces\V1\UserType\UserTypeServiceInterface;
use Modules\Auth\Resources\V1\UserTypeResource;
use Modules\Auth\Requests\V1\UserType\CreateUserTypeRequest;
use Modules\Auth\Requests\V1\UserType\UpdateUserTypeRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class UserTypeController extends BaseController
{
    public function __construct(protected UserTypeServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(UserTypeResource::collection($models)->resource))->success(message: "All user types.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(UserTypeResource::make($model)))->success(message: "User type details.");
    }

    public function create(CreateUserTypeRequest $request)
    {
        $this->modelService->create(UserTypeDTO::fromRequest($request));
        return (new Response())->success(message: "User type created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateUserTypeRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, UserTypeDTO::fromRequest($request));
        return (new Response())->success(message: "User type updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "User type deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "User type force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "User type restored successfully.");
    }

    public function deleteMany(DeleteManyRequest $request)
    {
        $this->modelService->deleteMany($request->validated('ids'));
        return (new Response())->success(message: "User types deleted successfully.");
    }
}
