<?php

namespace Modules\Auth\Interfaces\V1\Auth;

use Modules\Auth\DTO\V1\OtpDTO;
use Modules\Auth\DTO\V1\CodeDTO;
use Modules\Auth\DTO\V1\LoginDTO;
use Modules\Auth\DTO\V1\ResetPasswordDTO;
use Modules\Auth\DTO\V1\SendResetPasswordLinkDTO;
use Modules\Auth\DTO\V1\SignupDTO;
use Modules\Auth\DTO\V1\UserDTO;
use Modules\Core\DTO\BaseDTO;
use Modules\Stores\DTO\V1\StoreRequestDTO;

interface AuthServiceInterface
{
    public function login(LoginDTO $DTO): array;
    public function register(BaseDTO $DTO);
    public function refresh(/*string $userId*/): array;
    public function resetPassword(BaseDTO $DTO);
    public function changePassword(BaseDTO $DTO);
    public function sendCode(CodeDTO $DTO);
    public function checkOTP(OtpDTO $DTO);
}
