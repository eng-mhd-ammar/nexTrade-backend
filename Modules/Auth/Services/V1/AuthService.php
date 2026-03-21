<?php

namespace Modules\Auth\Services\V1;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Mails\OTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Modules\Auth\DTO\V1\CodeDTO;
use Modules\Auth\DTO\V1\LoginDTO;
use Modules\Auth\DTO\V1\OtpDTO;
use Modules\Auth\DTO\V1\SignupDTO;
use Modules\Auth\Exceptions\AuthException;
use Modules\Auth\Interfaces\V1\Auth\AuthServiceInterface;
use Modules\Auth\Models\User;
use Modules\Auth\Resources\V1\UserResource;
use Illuminate\Support\Str;
use Modules\Core\Services\BaseAuthService;
use Modules\Stores\Models\StoreRequest;

class AuthService extends BaseAuthService implements AuthServiceInterface
{
    protected string $model = User::class;
    protected string $guard = 'user';
    protected bool $checkActivity = false;
    protected array $columns = [/*'username', */'email'];
    protected bool $markAsActivated = true;
}
