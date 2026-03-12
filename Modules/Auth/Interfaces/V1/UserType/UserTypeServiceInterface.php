<?php

namespace Modules\Auth\Interfaces\V1\UserType;

use Modules\Auth\DTO\V1\UserTypeDTO;

interface UserTypeServiceInterface
{
    public function index();
    public function show(string $modelId);
    public function create(UserTypeDTO $DTO);
    public function update(string $modelId, UserTypeDTO $DTO);
    public function delete(string $modelId);
    public function ForceDelete(string $modelId);
    public function restore($modelId);
}
