<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Item;
use App\Models\Order;
use App\Models\Rate;
use App\Traits\ApiTrait;
use App\Traits\NotificationTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    use ApiTrait;
    use NotificationTrait;

    public function add(Request $request)
    {
        try {
            $rules = [
                'receive_type' => 'required',
                'payment_type' => 'required',
                'shipping' => 'required',
                'price' =>  'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $address = Address::find($request->address_id);
            if (!$address && $request->address_id) return $this->returnError('Address Not Found');
            $coupon = Coupon::find($request->coupon_id);
            if (!$coupon && $request->coupon_id) return $this->returnError('Coupon Not Found');
            if ($request->coupon_id && $coupon->expired_date < Carbon::now()) return $this->returnError('Coupon Was Expired');
            if ($request->coupon_id && $coupon->count <= 0) return $this->returnError('Coupon Was Ended');
            if ($request->coupon_id && $coupon) {
                $coupon->count--;
                $coupon->save();
            }
            $price = !$request->coupon_id ?  $request->price : $request->price - ($request->price * $coupon->discount / 100);
            $user = auth()->user();
            $data = [
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'receive_type' => $request->receive_type,
                'payment_type' => $request->payment_type,
                'shipping' => $request->receive_type == 'drive_thru' ? 0 : $request->shipping,
                'price' =>  $price,
                'total_price' => $request->shipping + $price,
            ];
            if ($request->coupon_id) $data['coupon_id'] = $coupon->id;
            $order = Order::create($data);
            Cart::whereNull('order_id')
                ->where('user_id', $user->id)
                ->update(['order_id' => $order->id]);
            $items = Cart::where('order_id', $order->id)->get();
            $items->map(function ($element) {
                $item = Item::find($element->item_id);
                $item->count -= $element->count;
                $item->save();
            });
            return $this->returnSuccessMessage('Order Created');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getPending()
    {
        try {
            $user = auth()->user();
            $data = Order::where('user_id', $user->id)->whereNot('status', 4)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getArchived()
    {
        try {
            $user = auth()->user();
            $orders = Order::where('user_id', $user->id)->where('status', 4)->get();
            $user = auth()->user();
            $data = $orders->map(function ($order) use ($user) {
                $rate = Rate::where('user_id', $user->id)->where('order_id', $order->id)->first();
                if ($rate) {
                    $order['rated'] = true;
                    return $order;
                } else {
                    $order['rated'] = false;
                    return $order;
                }
            });
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getDetails(Request $request)
    {
        try {
            $rules = ['order_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::find($request->order_id);
            if (!$order) return $this->returnError('Order Not Found');
            $user = auth()->user();
            $data = [];
            $items = Cart::where('order_id', $order->id)->get();
            if (!$items) return $this->returnError('No Items Found');
            $address = [];
            if ($order->address_id) $address = Address::where('user_id', $user->id)->find($order->address_id);
            $items = $items->map(function ($element) {
                $item = $element->items;
                $item['count'] = $element['count'];
                $item['price'] = $element['price'];
                return $item;
            });
            $data['items'] = $items;
            $data['address'] = $address;
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::find($request->order_id);
            if (!$order) return $this->returnError('Order Not Found');
            if ($order->status > 0) return $this->returnError('Already Approved');
            $order->delete();
            return $this->returnSuccessMessage('Deleted');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function rate(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
                'rate' => 'required|max:5|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::find($request->order_id);
            if (!$order) return $this->returnError('Order Not Found');
            $user = auth()->user();
            $data = [
                'user_id' => $user->id,
                'rating' => $request->rate,
                'comment' => $request->comment,
                'order_id' => $order->id,
            ];
            Rate::create($data);
            return $this->returnSuccessMessage('Rate Created');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
