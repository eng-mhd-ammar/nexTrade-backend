<?php

namespace App\Http\Controllers\Api\Admins;

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

    public function getArchived()
    {
        try {
            $data = Order::where('status', 4)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getPending()
    {
        try {
            $data = Order::where('status', 0)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function getAccepted()
    {
        try {
            $data = Order::whereNot('status', 0)->whereNot('status', 4)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function approve(Request $request)
    {
        try {
            $rules = ['order_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::find($request->order_id);
            if (!$order) return $this->returnError('Order Not Found');
            if ($order->status != 0)  return $this->returnError('Already Approved');
            $order->status++;
            $order->save();
            $notData = [
                'page_name' => 'order',
            ];
            $notTitle = 'order_approved';
            $notBody = "order_number { {$order->id} } has_been_approved";
            $topic = "users{$order->user_id}";
            $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
            $notificationController = new NotificationController();
            $notificationController->addNotification($notTitle, $notBody, $order->user_id);
            return $this->returnSuccessMessage('Approved');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function prepare(Request $request)
    {
        try {
            $rules = ['order_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $order = Order::find($request->order_id);
            if (!$order) return $this->returnError('Order Not Found');
            if ($order->status != 1)  return $this->returnError('Already Prepared');
            $order->receive_type == 'delivery' ? $order->status++ : $order->status = 4;
            $order->save();
            $notificationController = new NotificationController();
            if ($order->receive_type == 'delivery') {
                $notData = ['page_name' => 'order'];
                $notTitle = 'order_prepared';
                $notBody = "order_number { {$order->id} } has_been_prepared";
                $topic = "users{$order->user_id}";
                $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
                $notificationController->addNotification($notTitle, $notBody, $order->user_id);
                $notTitle = 'alert';
                $notBody = "order_number { {$order->id} } ready_to_deliver";
                $topic = 'deliveries';
                $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
                $notificationController->addNotification($notTitle, $notBody);
            } else {
                $notData = ['page_name' => 'order'];
                $notTitle = 'order_received';
                $notBody = "order_number { {$order->id} } has_been_received";
                $topic = "users{$order->user_id}";
                $this->sendNotificationToTopic($topic, $notTitle, $notBody, $notData);
                $notificationController->addNotification($notTitle, $notBody, $order->user_id);
            }
            return $this->returnSuccessMessage('Prepared');
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
