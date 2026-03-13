<?php

namespace Modules\Auth\Exceptions;

use Modules\Core\Exceptions\BaseException;
use Modules\Core\Utilities\Response;

class AuthException extends BaseException
{
    public static function invalidCredentials()
    {
        throw new self('Invalid email or password.', Response::HTTP_NOT_FOUND);
    }

    public static function accountHasBeenDeactivated()
    {
        throw new self('Your account has been deactivated. Please contact support.', Response::HTTP_FORBIDDEN);
    }

    public static function unverifiedAccount()
    {
        throw new self('Your email address is not verified. Please verify it and try again.', Response::HTTP_FORBIDDEN);
    }

    public static function invalidOtpProvided()
    {
        throw new self('Invalid OTP. Please try again.', Response::HTTP_BAD_REQUEST);
    }

    public static function otpTimeout()
    {
        throw new self('The OTP has expired. Please request a new one.', Response::HTTP_BAD_REQUEST);
    }

    public static function invalidOldPassword()
    {
        throw new self('Invalid old password.', Response::HTTP_BAD_REQUEST);
    }

    public static function invalidNewPassword()
    {
        throw new self('The new password must be different from the old password.', Response::HTTP_BAD_REQUEST);
    }

    public static function invalidTokenProvided()
    {
        throw new self('Invalid token type provided.', Response::HTTP_NOT_FOUND);
    }

    public static function notAnAdmin()
    {
        throw new self('You are not an admin.', Response::HTTP_BAD_REQUEST);
    }
}
