<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    use ApiTrait;

    public function get()
    {
        try {
            $user = auth()->user();
            $data = Notification::where('user_id', $user->id)->orderBy('id', 'desc')->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
