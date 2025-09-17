<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Item;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    use ApiTrait;

    public function add(Request $request)
    {
        try {
            $rules = [
                'item_id' => 'required',
                'count' => 'integer|required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            $user = auth()->user();
            $cartItem = Cart::where('user_id', $user->id)->where('item_id', $item->id)->where('order_id', null)->first();
            if (!$cartItem) {
                $data = [
                    'user_id' => $user->id,
                    'item_id' => $item->id,
                    'count' => $request->count,
                    'price' => $item->price,
                ];
                Cart::create($data);
                return $this->returnSuccessMessage('Added To Cart');
            } else {
                $cartItem->count += $request->count;
                $cartItem->save();
                return $this->returnSuccessMessage('Added To Cart');
            }
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function remove(Request $request)
    {
        try {
            $rules = [
                'item_id' => 'required',
                'count' => 'integer|required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            $user = auth()->user();
            $cartItem = Cart::where('user_id', $user->id)->where('item_id', $item->id)->whereNull('order_id')->first();
            if (!$cartItem) return $this->returnError('Item Not Found In Cart');
            if ($cartItem->count  <= $request->count) $cartItem->delete();
            else {
                $cartItem->count -= $request->count;
                $cartItem->save();
            }
            $cartItem->save();
            return $this->returnSuccessMessage('Removed From Cart');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function get()
    {
        try {
            $user = auth()->user();
            $data = $user->cartItems()->whereNull('order_id')->get();
            $modifiedData = $data->map(function ($item) {
                $user = auth()->user();
                unset($item['pivot']);
                $item['count'] = Cart::where('user_id', $user->id)->where('item_id', $item['id'])->whereNull('order_id')->first()->count;
                return $item;
            });
            return $this->returnData('data', $modifiedData);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }


    public function update(Request $request)
    {
        try {
            $rules = [
                'item_id' => 'required',
                'count' => 'integer|required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            $user = auth()->user();
            $data = Cart::where('user_id', $user->id)->where('item_id', $item->id)->whereNull('order_id')->first();
            if (!$data) return $this->returnError('Item Not Found In Cart');
            if ($request->count == 0) $data->delete();
            else {
                $data->count = $request->count;
                $data->save();
            }
            return $this->returnSuccessMessage('Updated');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function delete(Request $request)
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
            $data = Cart::where('user_id', $user->id)->where('item_id', $item->id)->whereNull('order_id')->first();
            if (!$data) return $this->returnError('Item Not Found In Cart');
            $data->delete();
            return $this->returnSuccessMessage('Deleted');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
