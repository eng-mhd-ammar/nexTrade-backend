<?php

namespace App\Traits;

use Exception;
use Kawankoding\Fcm\Fcm;

trait NotificationTrait
{
    public function sendNotificationToTopic($topic, $title, $body, $data = [''])
    {
        try {
            $fcm = new Fcm(env('FCM_SERVER_KEY'));
            $fcm->toTopic($topic)
                ->priority('normal')
                ->data($data)
                ->notification([
                    'title' => $title,
                    'body' => $body,
                ])
                // ->enableResponseLog()
                ->send();
        } catch (Exception $e) {
            return $this->returnError('E500', $e->getMessage());
        }
    }

    public function sendNotificationToTokens($tokens, $title, $body, $data = [''])
    {
        try {
            $fcm = new Fcm(env('FCM_SERVER_KEY'));
            $fcm->to($tokens)
                ->priority('normal')
                ->data($data)
                ->notification([
                    'title' => $title,
                    'body' => $body,
                ])
                // ->enableResponseLog()
                ->send();
        } catch (Exception $e) {
            return $this->returnError('E500', $e->getMessage());
        }
    }
}
