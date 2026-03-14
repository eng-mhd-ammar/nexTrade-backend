<?php

namespace Modules\Product\Interfaces\V1\Stock;

use Modules\Product\DTO\V1\StockDTO;

interface StockServiceInterface
{
    public function index();
    public function show(string $modelId);
    public function create(StockDTO $DTO);
    public function update(string $modelId, StockDTO $DTO);
    public function delete(string $modelId);
    public function ForceDelete(string $modelId);
    public function restore($modelId);
    public function deleteMany(array $ids);
}
