<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;

trait PaginationTrait
{
    private function getPaginateData(Model $model, $countPerPage)
    {
        try {
            $data = $model::paginate($countPerPage);
            return response()->json([
                'data' => $data->items(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ]);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
