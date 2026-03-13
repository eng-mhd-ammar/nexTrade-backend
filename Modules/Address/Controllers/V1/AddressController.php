<?php

namespace Modules\Address\Controllers\V1;

use Modules\Address\DTO\V1\AddressDTO;
use Modules\Address\Interfaces\V1\Address\AddressServiceInterface;
use Modules\Address\Resources\V1\AddressResource;
use Modules\Address\Requests\V1\Address\CreateAddressRequest;
use Modules\Address\Requests\V1\Address\UpdateAddressRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Core\Requests\DeleteManyRequest;
use Modules\Core\Utilities\Response;

class AddressController extends BaseController
{
    public function __construct(protected AddressServiceInterface $modelService)
    {
    }

    public function index()
    {
        $models = $this->modelService->index();
        return (new Response(AddressResource::collection($models)->resource))->success(message: "All addresses.");
    }

    public function show(string $modelId)
    {
        $model = $this->modelService->show($modelId);
        return (new Response(AddressResource::make($model)))->success(message: "Address details.");
    }

    public function create(CreateAddressRequest $request)
    {
        $this->modelService->create(AddressDTO::fromRequest($request));
        return (new Response())->success(message: "Address created successfully.", code: Response::HTTP_CREATED);
    }

    public function update(UpdateAddressRequest $request, string $modelId)
    {
        $this->modelService->update($modelId, AddressDTO::fromRequest($request));
        return (new Response())->success(message: "Address updated successfully.");
    }

    public function delete(string $modelId)
    {
        $this->modelService->delete($modelId);
        return (new Response())->success(message: "Address deleted successfully.");
    }

    public function ForceDelete(string $modelId)
    {
        $this->modelService->ForceDelete($modelId);
        return (new Response())->success(message: "Address force deleted successfully.");
    }

    public function restore(string $modelId)
    {
        $this->modelService->restore($modelId);
        return (new Response())->success(message: "Address restored successfully.");
    }
}
