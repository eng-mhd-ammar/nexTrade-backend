<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Item;
use App\Models\Setting;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    use ApiTrait;

    public function get()
    {
        try {
            $data = Category::all();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getHomeData()
    {
        try {
            $data = [];
            $categories = Category::all();
            $data['categories'] = $categories;
            $data['offers_items'] = Item::whereNot('discount', 0)->where('active', true)->with('category')->get();
            $top_items = Cart::whereNot('order_id', null)->groupBy('item_id')->selectRaw('item_id, sum(count) as count')->orderBy('count', 'desc')->take(10)->get();
            $data['top_items'] = $top_items->map(function ($item) {
                $count = $item->count;
                $item = $item->items;
                $item['count'] = $count;
                return $item;
            });
            $data['settings'] = Setting::all();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
