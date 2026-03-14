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
use Modules\Stores\Models\StoreRequest;

class AuthService implements AuthServiceInterface
{
    protected string $model = User::class;

    protected array $columns = ['email'];

    public function login(LoginDTO $DTO): array
    {
        // Attempt to find the user by any login column
        $user = $this->model::with('type')
            ->whereAny($this->columns, $DTO->getLoginFieldValue())
            ->firstOr(fn () => $this->throwInvalidCredentials());

        if ($user->email_verified_at === null) {
            $this->throwUnverifiedAccount();
        }

        // Validate password
        if (!Hash::check($DTO->password, $user->password)) {
            $this->throwInvalidCredentials();
        }

        // Update last login timestamp
        $user->update(['last_login_at' => now()]);

        // Determine abilities/permissions
        $abilities = ["user","admin","delivery"];
        // $abilities = optional($user->role)->permissions ?? [$user->role->name ?? 'user'];

        // Create token
        $tokenName = 'apiToken_' . now()->timestamp;
        $token = $user->createToken($tokenName, $abilities, now()->addWeek())->plainTextToken;

        return [
            'token' => $token,
            'user'  => new UserResource($user),
            'expires_at' => now()->addWeek()->toDateTimeString(), // useful for frontend
        ];
    }


    public function signup(SignupDTO $DTO)
    {
        $addresses = $DTO->addresses;

        $user = $this->model::create($DTO->filterNull()->toArray());
        $this->handleAddresses($addresses, $user);
        $user->update(['verification_code' => rand(10000, 99999), 'code_expired_at' => now()->addMinutes(10)]);
        Mail::to($user->email)->send(new OTPMail($user->verification_code, $user->full_name));
    }

    public function sendCode(CodeDTO $DTO)
    {
        $user = $this->model::query()
            ->where('email', $DTO->email)
            ->first();
        if (!$user) {
            return $this->throwInvalidCredentials();
        }

        $user->email_verified_at = null;

        $user->update(['verification_code' => rand(10000, 99999), 'code_expired_at' => now()->addMinutes(10)]);

        Mail::to($DTO->email)->send(new OTPMail($user->verification_code, $user->full_name));
    }

    public function checkOTP(OtpDTO $DTO)
    {

        $model = $this->model::query()
            ->where('email', $DTO->email)
            ->firstOrFail();

        if ($model->verification_code != $DTO->code) {
            $this->throwInvalidOTP();
        }

        if (now()->greaterThan($model->code_expired_at)) {
            $this->throwOtpTimeout();
        }
        $model->markEmailAsVerified();

        $data['token'] = $model->createToken('apiToken', [$model->type->name], now()->addWeek())->plainTextToken;
        $data['user'] = UserResource::make($model);

        return $data;
    }

    public function resetPassword($DTO)
    {
        $user = User::query()->where('email', $DTO->email)->first();
        $token = $user->passwordResetToken?->token;

        if (!($user->passwordResetToken && Hash::check($DTO->token, $token))) {
            return back()->withErrors(['error' => 'رمز إعادة تعيين كلمة المرور غير صالح']);
        }

        $status = Password::reset(
            $DTO->toArray(),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return view('auth::Auth.password-changed-successfully');
        } else {
            return back()->withErrors(['error' => $status]);
        }
    }

    public function sendResetLink($DTO)
    {
        $user = User::query()->where('email', $DTO->email)->first();

        if (!$user) {
            $this->throwInvalidCredentials();
        }

        $status = Password::sendResetLink(['email' => $DTO->email]);

        if ($status !== Password::RESET_LINK_SENT) {
            $this->throwInvalidCredentials();
        }

        return $user;
    }

    private function handleAddresses($addresses, $model)
    {
        $addressIds = [];
        if (is_array($addresses)) {
            foreach ($addresses as $address) {
                $address = $model->addresses()->updateOrCreate(
                    ['id' => $address['id'] ?? null],
                    array_filter($address, fn ($value) => !is_null($value))
                );
                $addressIds[] = $address->id;
            }
        }
        $model->addresses()->whereNotIn('id', $addressIds)->forceDelete();
    }

    public function throwInvalidCredentials()
    {
        AuthException::invalidCredentials();
    }

    public function throwActivationException()
    {
        AuthException::accountHasBeenDeactivated();
    }
    public function throwUnverifiedAccount()
    {
        AuthException::unverifiedAccount();
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
