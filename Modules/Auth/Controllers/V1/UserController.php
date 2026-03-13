<?php

namespace Modules\Auth\Controllers\V1;

use Modules\Auth\DTO\V1\UserDTO;
use Modules\Auth\Interfaces\V1\User\UserServiceInterface;
use Modules\Auth\Resources\V1\UserResource;
use Modules\Auth\Requests\V1\User\CreateUserRequest;
use Modules\Auth\Requests\V1\User\UpdateUserRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class UserController extends BaseController
{
    public function __construct(protected UserServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(UserResource::collection($models)->resource))->success(message: "All users.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(UserResource::make($model)))->success(message: "User details.");
    }

    public function create(CreateUserRequest $request)
    {
        $this->modelService->create(UserDTO::fromRequest($request));
        return (new Response())->success(message: "User created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, UserDTO::fromRequest($request));
        return (new Response())->success(message: "User updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "User deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "User force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "User restored successfully.");
    }
}
