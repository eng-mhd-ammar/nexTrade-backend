<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    use ApiTrait;

    public function addNotification($title, $body, $id = null)
    {
        $data = [
            'title' => $title,
            'body' => $body,
            'user_id' => $id
        ];
        Notification::create($data);
    }
}
