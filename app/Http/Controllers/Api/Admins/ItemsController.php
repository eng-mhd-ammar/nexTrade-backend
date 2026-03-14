<?php

namespace App\Http\Controllers\Api\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{

    use ApiTrait;

    public function create(Request $request)
    {
        try {
            $rules = [
                'name_ar' => 'required',
                'desc_ar' => 'required',
                'name_en' => 'required',
                'desc_en' => 'required',
                'count' => 'required',
                'price' => 'required',
                'discount' => 'required',
                'image' => 'required',
                'category_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $path = $request->file('image')->store('images/items', 'public');
            $data = [
                'name_ar' => $request->name_ar,
                'desc_ar' => $request->desc_ar,
                'name_en' => $request->name_en,
                'desc_en' => $request->desc_en,
                'count' => $request->count,
                'price' => $request->price,
                'discount' => $request->discount,
                'image' => $path,
                'category_id' => $request->category_id,
            ];
            Item::create($data);
            return $this->returnSuccessMessage('Item Created');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $rules = ['item_id'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            Storage::disk('public')->delete($item->image);
            $item->delete();
            return $this->returnSuccessMessage('Item Deleted');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $rules = [
                'item_id' => 'required',
                'name_en' => 'required',
                'name_ar' => 'required',
                'desc_ar' => 'required',
                'desc_en' => 'required',
                'count' => 'required',
                'active' => 'required',
                'price' => 'required',
                'discount' => 'required',
                'category_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $item = Item::find($request->item_id);
            if (!$item) return $this->returnError('Item Not Found');
            if ($request->image) {
                Storage::disk('public')->delete($item->image);
                $path = $request->file('image')->store('images/items', 'public');
                $item->image = $path;
            }
            if ($item->name_en != $request->name_en) $item->name_en = $request->name_en;
            if ($item->name_ar != $request->name_ar) $item->name_ar = $request->name_ar;
            if ($item->desc_ar != $request->desc_ar) $item->desc_ar = $request->desc_ar;
            if ($item->desc_en != $request->desc_en) $item->desc_en = $request->desc_en;
            if ($item->count != $request->count) $item->count = $request->count;
            if ($item->active != $request->active) $item->active = $request->active;
            if ($item->price != $request->price) $item->price = $request->price;
            if ($item->discount != $request->discount) $item->discount = $request->discount;
            if ($item->category_id != $request->category_id) $item->category_id = $request->category_id;
            $item->save();
            return $this->returnSuccessMessage('Item Updated');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function get(Request $request)
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
