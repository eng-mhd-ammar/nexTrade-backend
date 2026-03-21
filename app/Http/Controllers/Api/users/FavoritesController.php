<?php

namespace App\Http\Controllers\Api\users;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Item;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    use ApiTrait;

    public function addOrRemove(Request $request)
    {
        try {
            $rules = [
                'item_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            $user = auth()->user();
            $fav = Favorite::where('user_id', $user->id)->where('item_id', $item->id)->first();
            if (!$fav) {
                $data = ['user_id' => $user->id, 'item_id' => $item->id];
                Favorite::create($data);
                return $this->returnSuccessMessage('Item Added To Favorites');
            }
            $fav->delete();
            return $this->returnSuccessMessage('Item Deleted From Favorites');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function get()
    {
        try {
            $user = auth()->user();
            $data = $user->favoritesItems()->get();
            $modifiedData = $data->map(function ($item) {
                unset($item['pivot']);
                return $item;
            });
            return $this->returnData('data', $modifiedData);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
