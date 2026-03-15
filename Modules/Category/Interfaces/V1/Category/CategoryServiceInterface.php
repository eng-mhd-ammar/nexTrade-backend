<?php

namespace Modules\Category\Interfaces\V1\Category;

use Modules\Category\DTO\V1\CategoryDTO;

interface CategoryServiceInterface
{
    public function index();
    public function show(string $modelId);
    public function create(CategoryDTO $DTO);
    public function update(string $modelId, CategoryDTO $DTO);
    public function delete(string $modelId);
    public function ForceDelete(string $modelId);
    public function restore($modelId);
    public function deleteMany(array $ids);
}
