<?php

namespace Modules\Core\Services;

use Modules\Core\DTO\OtpDTO;
use Modules\Core\DTO\CodeDTO;
use Modules\Core\Enums\GuardType;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Core\DTO\ResetPasswordDTO;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\DTO\ChangePasswordDTO;
use Modules\Core\DTO\BaseDTO;
use Modules\Core\Exceptions\AuthException;
use Modules\Auth\Resources\V1\UserResource;

class BaseAuthService
{
    protected string $model = Model::class;
    protected string $guard;
    protected array $columns = [/*'username', */'email'];
    protected bool $checkActivity = true;
    protected bool $markAsActivated = false;

    public function login(BaseDTO $DTO): array
    {
        $model = $this->model::whereAny($this->columns, $DTO->getLoginFieldValue())->firstOr(fn () => $this->throwInvalidCredentials());
        if ($this->checkActivity) {
            $model->is_active === true ?: $this->throwActivationException();
        }

        if ($DTO->email && $model->email_verified_at === null) {
            $this->throwUnverifiedPhoneAccount();
        }
        if (!Hash::check($DTO->password, $model->password)) {
            $this->throwInvalidCredentials();
        }

        $tokens = JWTToken::tokens($model->id, $this->guard);

        $tokens['profile'] = UserResource::make($model);

        return $tokens;
    }

    public function register(BaseDTO $DTO)
    {
        $model = $this->model::query()->create($DTO->toArray());

        $data = UserResource::make($model);

        $this->sendCode(new CodeDTO($model->email));

        return $data;
    }

    public function refresh(/*string $modelId*/): array
    {
        $refreshToken = request()->input('refresh_token');

        if (!$refreshToken) {
            $this->throwInvalidRefreshToken();
        }

        try {
            $payload = JWTAuth::setToken($refreshToken)->getPayload();
        } catch (\Exception $e) {
            $this->throwInvalidRefreshToken();
        }

        $userId = $payload['sub'] ?? null;
        $guard  = $payload['guard'] ?? GuardType::USER->value;

        if (!$userId) {
            return $this->throwInvalidRefreshToken();
        }

        $data['access_token'] = JWTToken::accessTokenById($userId);
        $data['refresh_token'] = $refreshToken;

        return $data;
    }

    // public function refresh(string $modelId): array
    // {
    //     $refreshToken = request()->cookie('refresh_token');
    //     if(!$refreshToken) $this->throwInvalidRefreshToken();

    //     $payload = JWTAuth::setToken($refreshToken)->getPayload();
    //     $userId  = $payload['sub'] ?? null;
    //     $guard   = $payload['guard'] ?? 'user';

    //     if(!$userId) $this->throwInvalidRefreshToken();

    //     $accessToken = JWTToken::accessTokenById($modelId);
    //     if(!$accessToken) $this->throwInvalidTokenProvided();

    //     $newRefreshToken = JWTToken::refreshTokenById($userId, $guard);

    //     return [
    //         'access_token' => $accessToken,
    //         'refresh_token' => $newRefreshToken,
    //     ];
    // }

    public function sendCode(BaseDTO $DTO)
    {
        $model = $this->model::query()
                ->where('email', $DTO->email)
                ->firstOrFail();

        $code = $this->getRandomCode();

        $model = $model->update(['code' => $code, 'code_expired_at' => now()->addMinutes(10)]);

        // dump('sms', $code); // Send SMS
    }

    public function checkOTP(BaseDTO $DTO)
    {
        $model = $this->model::query()
            ->where('email', $DTO->email)
            ->firstOrFail();

        if ($model->code != $DTO->code) {
            $this->throwInvalidOTP();
        }

        if (now()->greaterThan($model->code_expired_at)) {
            $this->throwOtpTimeout();
        }

        if ($this->checkActivity && $model->is_active === false) {
            $this->throwActivationException();
        }
        if (strtolower(request()->header('type')) == "reset") {
            return JWTToken::resetToken($model->id, $this->guard);
        } else {

            if ($this->markAsActivated) {
                $model->markAsPhoneVerified();
            }

            return JWTToken::tokens($model->id, $this->guard);
        }
    }

    public function resetPassword(BaseDTO $DTO)
    {
        Auth::shouldUse($this->guard);
        JWTAuth::setToken(request()->get('reset_token'));
        $model = JWTAuth::authenticate();

        $payload = JWTAuth::getPayload();
        if ($payload['utt'] === 'RESET' && $payload['guard'] === $this->guard) {
            $model->update(['password' => $DTO->password]);
            JWTAuth::invalidate(JWTAuth::getToken());
        } else {
            $this->throwInvalidTokenProvided();
        }
    }

    public function changePassword(BaseDTO $DTO)
    {
        $model = Auth::guard($this->guard)->user();
        if (!Hash::check($DTO->old_password, $model->password)) {
            $this->throwInvalidOldPassword();
        }
        if ($DTO->old_password == $DTO->new_password) {
            $this->throwInvalidNewPassword();
        }

        $model->update(['password' => $DTO->new_password]);
    }

    private function getRandomCode(): string
    {
        return 123456; // rand(100000, 999999);
    }

    public function throwInvalidCredentials()
    {
        AuthException::invalidCredentials();
    }

    public function throwInvalidRefreshToken()
    {
        AuthException::invalidRefreshToken();
    }

    public function throwActivationException()
    {
        AuthException::accountHasBeenDeactivated();
    }
    public function throwUnverifiedAccount()
    {
        AuthException::unverifiedAccount();
    }
    public function throwUnverifiedPhoneAccount()
    {
        AuthException::unverifiedPhoneAccount();
    }
    public function throwUnverifiedMailAccount()
    {
        AuthException::unverifiedMailAccount();
    }

    public function throwInvalidOTP()
    {
        AuthException::invalidOtpProvided();
    }

    public function throwOtpTimeout()
    {
        AuthException::otpTimeout();
    }
    public function throwInvalidOldPassword()
    {
        AuthException::invalidOldPassword();
    }
    public function throwInvalidNewPassword()
    {
        AuthException::invalidNewPassword();
    }
    public function throwInvalidTokenProvided()
    {
        AuthException::invalidTokenProvided();
    }
}
