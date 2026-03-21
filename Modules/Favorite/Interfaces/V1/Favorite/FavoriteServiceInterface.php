<?php

namespace Modules\Favorite\Interfaces\V1\Favorite;

use Modules\Favorite\DTO\V1\FavoriteDTO;

interface FavoriteServiceInterface
{
    public function index();
    public function show(string $modelId);
    public function create(FavoriteDTO $DTO);
    public function update(string $modelId, FavoriteDTO $DTO);
    public function delete(string $modelId);
    public function ForceDelete(string $modelId);
    public function restore($modelId);
    public function deleteMany(array $ids);
}
