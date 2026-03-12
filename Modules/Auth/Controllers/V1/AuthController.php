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
        $data = $this->authService->login(LoginDTO::fromRequest($request));
        return (new Response($data))->success(message: "Logged in successfully.");
    }

    public function signup(SignUpRequest $request): JsonResponse
    {
        $data = $this->authService->signup(SignupDTO::fromRequest($request));
        return (new Response($data))->success(message: "signed up successfully.");
    }

    public function signupWithStore(SignUpWithStoreRequest $request): JsonResponse
    {
        $data = $this->authService->signupWithStore(UserDTO::fromArray($request->validated()), StoreRequestDTO::fromArray($request->validated()));
        return (new Response($data))->success(message: "signed up successfully.");
    }

    public function send_otp(SendCodeRequest $request)
    {
        $tokens = $this->authService->sendCode(CodeDTO::fromRequest($request));
        return (new Response($tokens))->success(message: "OTP sent successfully.");
    }

    public function check_otp(OtpRequest $request)
    {

        $tokens = $this->authService->checkOTP(OtpDTO::fromRequest($request));
        return (new Response($tokens))->success(message: "Verified Successfully.");
    }

    public function sendResetLink(SendResetPasswordLinkRequest $request)
    {
        $user = $this->authService->sendResetLink(SendResetPasswordLinkDTO::fromRequest($request));
        return (new Response())->success(message: "Email Sent Successfully.");
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $this->authService->resetPassword(ResetPasswordDTO::fromRequest($request));
        return $data;
    }
}
