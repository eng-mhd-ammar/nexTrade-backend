<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{

    use ApiTrait;

    public function getItems(Request $request)
    {
        try {
            $rules = ['category_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $category = Category::find($request->category_id);
            if (!$category) return $this->returnError('Category Not Found');
            $user = auth()->user();
            $items = Item::where('category_id', $category->id)->get();
            $userFavorites = $user->favoritesItems->pluck('id')->toArray();
            $data = $items->map(function ($item) use ($userFavorites) {
                $itemData = $item->toArray();
                $itemData['favorite'] = in_array($item->id, $userFavorites);
                return $itemData;
            });
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $user = auth()->user();
            $items = Item::where('name_en', 'LIKE', "%$request->name%")->orWhere('name_ar', 'LIKE', "%$request->name%")->get();
            $userFavorites = $user->favoritesItems->pluck('id')->toArray();
            $data = $items->map(function ($item) use ($userFavorites) {
                $itemData = $item->toArray();
                $itemData['favorite'] = in_array($item->id, $userFavorites);
                return $itemData;
            });
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

}
