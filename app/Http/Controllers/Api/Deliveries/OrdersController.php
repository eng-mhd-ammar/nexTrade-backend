<?php

namespace App\Http\Controllers\Api\Deliveries;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    use ApiTrait;

    public function approve(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::where('id', $request->order_id)->where('receive_type', 'delivery')->first();
            if (!$order) return $this->returnError('Order Not Found');
            if ($order->status != 2)  return $this->returnError('Already Approved');
            $user = auth()->user();
            $order->status++;
            $order->delivery_id = $user->id;
            $order->save();
            $notData = ['page_name' => 'order'];
            $notTitle = 'order_approved_from_delivery';
            $notBody = "order_number { {$order->id} } on_the_deliver";
            $topic = "users{$order->user_id}";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController = new NotificationController();
            $notificationController->addNotification($notTitle, $notBody, $order->user_id);
            $notTitle = 'order_approved_from_delivery';
            $notBody = "order_number { {$order->id} } approved_by_a_delivery_number { {$order->user_id} }";
            $topic = "admins";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController->addNotification($notTitle, $notBody);
            $notTitle = 'order_approved_from_delivery';
            $notBody = "order_number { {$order->id} } approved_by_a_delivery_number { {$order->user_id} }";
            $topic = "deliveries";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController->addNotification($notTitle, $notBody);
            return $this->returnSuccessMessage('Approved');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function deliver(Request $request)
    {
        try {
            $rules = [
                'order_id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::where('id', $request->order_id)->where('receive_type', 'delivery')->first();
            if (!$order) return $this->returnError('Order Not Found');
            if ($order->status != 3)  return $this->returnError('Already Delivered');
            $order->status++;
            $order->save();
            $notData = ['page_name' => 'order'];
            $notTitle = 'order_delivered';
            $notBody = "order_number { {$order->id} } has_been_delivered_number { {$order->user_id} }";
            $topic = "users{$order->user_id}";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController = new NotificationController();
            $notificationController->addNotification($notTitle, $notBody, $order->user_id);
            $notBody = "order_number { {$order->id} } has_been_delivered_number { {$order->user_id} }";
            $topic = "admins";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController->addNotification($notTitle, $notBody);
            return $this->returnSuccessMessage('Approved');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getPending()
    {
        try {
            $data = Order::where('status', 2)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getArchived()
    {
        try {
            $user = auth()->user();
            $data = Order::where('status', 4)->where('delivery_id', $user->id)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getAccepted()
    {
        try {
            $user = auth()->user();
            $data = Order::where('status', 3)->where('delivery_id', $user->id)->get();
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
            // $user = User::find($order->user_id);
            $data = [];
            $items = Cart::where('order_id', $order->id)->get();
            if (!$items) return $this->returnError('No Items Found');
            $address = [];
            if ($order->address_id) $address = Address::find($order->address_id);
            if ($order->address_id && !$address) return $this->returnError('Address Not Found');
            $items = $items->map(function ($item) use ($order) {
                $count = $item->count;
                $item = $item->items;
                $item['price'] = $item['price'] - ($item['price'] * $item['discount'] / 100);
                if ($order->coupon_id) {
                    $coupon = Coupon::find($order->coupon_id);
                    $item['price'] = $item['price'] - ($item['price'] * $coupon->discount / 100);
                }
                if ($order->coupon_id)
                    $item['count'] = $count;
                return $item;
            });
            $data['items'] = $items;
            $data['address'] = $address;
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
