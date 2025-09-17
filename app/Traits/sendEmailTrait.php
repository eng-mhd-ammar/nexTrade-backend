<?php

namespace App\Traits;

use App\Mail\VerificationCodeEmail;
use Exception;
use Illuminate\Support\Facades\Mail;

trait SendEmailTrait
{
    private function sendVerificationEmail($email, $user, $verificationCode)
    {
        try {
            Mail::to($email)->send(new VerificationCodeEmail($user, $verificationCode));
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
