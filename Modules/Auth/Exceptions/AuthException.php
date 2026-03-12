<?php

namespace Modules\Auth\Exceptions;

use Modules\Core\Exceptions\BaseException;
use Modules\Core\Utilities\Response;

class AuthException extends BaseException
{
    public static function invalidCredentials()
    {
        throw new self('البريد الإلكتروني أو كلمة المرور خاطئة.', Response::HTTP_NOT_FOUND);
    }
    public static function accountHasBeenDeactivated()
    {
        throw new self('تم إالغاء تفعيل حسابك، رجاءً تواصل مع الدعم الفني.', Response::HTTP_FORBIDDEN);
    }
    public static function unverifiedAccount()
    {
        throw new self('البريد الإلكتروني غير مفعل، الرجاء تفعيله ثم إعادة المحاولة.', Response::HTTP_FORBIDDEN);
    }
    public static function invalidOtpProvided()
    {
        throw new self('كلمة المرور خطائة، حاول مرة أخرى.', Response::HTTP_BAD_REQUEST);
    }
    public static function otpTimeout()
    {
        throw new self('انتهى مفعول كلمة المرور، الرجاء طلب كلمة مرور جديدة', Response::HTTP_BAD_REQUEST);
    }
    public static function invalidOldPassword()
    {
        throw new self('Invalid Old Password', Response::HTTP_BAD_REQUEST);
    }
    public static function invalidNewPassword()
    {
        throw new self('New Password Must Be Different From Old Password', Response::HTTP_BAD_REQUEST);
    }
    public static function invalidTokenProvided()
    {
        throw new self('Invalid Token Type Provided', Response::HTTP_NOT_FOUND);
    }
    public static function notAnAdmin()
    {
        throw new self('أنت لست مدير.', Response::HTTP_BAD_REQUEST);
    }
}
