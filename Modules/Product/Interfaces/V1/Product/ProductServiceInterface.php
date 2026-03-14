<?php

namespace Modules\Product\Interfaces\V1\Product;

use Modules\Product\DTO\V1\ProductDTO;

interface ProductServiceInterface
{
    public function index();
    public function show(string $modelId);
    public function create(ProductDTO $DTO);
    public function update(string $modelId, ProductDTO $DTO);
    public function delete(string $modelId);
    public function ForceDelete(string $modelId);
    public function restore($modelId);
    public function deleteMany(array $ids);
}
