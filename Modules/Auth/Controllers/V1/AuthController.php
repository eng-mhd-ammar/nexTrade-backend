<?php

namespace Modules\Auth\Controllers\V1;

use Modules\Core\Utilities\Response;
use Illuminate\Http\JsonResponse;
use Modules\Auth\DTO\V1\CodeDTO;
use Modules\Auth\DTO\V1\LoginDTO;
use Modules\Auth\DTO\V1\OtpDTO;
use Modules\Auth\DTO\V1\ResetPasswordDTO;
use Modules\Auth\DTO\V1\SignupDTO;
use Modules\Auth\Interfaces\V1\Auth\AuthServiceInterface;
use Modules\Auth\Requests\V1\Auth\LoginRequest;
use Modules\Auth\Requests\V1\Auth\OtpRequest;
use Modules\Auth\Requests\V1\Auth\ResetPasswordRequest;
use Modules\Auth\Requests\V1\Auth\SendCodeRequest;
use Modules\Auth\Requests\V1\Auth\SignUpRequest;
use Modules\Auth\DTO\V1\SendResetPasswordLinkDTO;
use Modules\Auth\DTO\V1\UserDTO;
use Modules\Auth\Requests\V1\Auth\SendResetPasswordLinkRequest;
use Modules\Auth\Requests\V1\Auth\SignUpWithStoreRequest;
use Modules\Core\Controllers\BaseController;
use Modules\Stores\DTO\V1\StoreRequestDTO;

class AuthController extends BaseController
{
    public function __construct(protected AuthServiceInterface $authService)
    {
    }



    public function login(LoginRequest $request): JsonResponse
    {
        $tokens = $this->authService->login(LoginDTO::fromRequest($request));

        // $data = ['access_token' => $tokens['access_token']];
        // $cookies = ['refresh_token' => $tokens['refresh_token']];

        return (new Response($tokens))->success(message: "Logged in successfully."/*, cookies: $cookies*/);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register(RegisterDTO::fromRequest($request));
        return (new Response($data))->success(message: "Registered successfully.");
    }

    public function checkOTP(OtpRequest $request)
    {
        $tokens = $this->authService->checkOTP(OtpDTO::fromRequest($request));

        // $data = ['access_token' => $tokens['access_token']];
        // $cookies = ['refresh_token' => $tokens['refresh_token']];

        return (new Response($tokens))->success(message: "Verified Successfully."/*, cookies: $cookies*/);
    }

    public function sendCode(SendCodeRequest $request)
    {
        $tokens = $this->authService->sendCode(CodeDTO::fromRequest($request));
        return (new Response($tokens))->success(message: "Otp sent successfully.");
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->authService->resetPassword(ResetPasswordDTO::fromRequest($request));
        return (new Response())->success(message: "Password was reset successfully.");
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $this->authService->changePassword(ChangePasswordDTO::fromRequest($request));
        return (new Response())->success(message: "Password was changed successfully.");
    }

    public function refresh()
    {
        $tokens = $this->authService->refresh(/*Auth::guard(GuardType::USER->value)->id()*/);

        // $data = ['access_token' => $tokens['access_token']];
        // $cookies = ['refresh_token' => $tokens['refresh_token']];

        return (new Response($tokens))->success(message: "Tokens refreshed successfully."/*, cookies: $cookies*/);
    }
}
