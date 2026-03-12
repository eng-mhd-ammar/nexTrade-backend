<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Auth\ResetPasswordRequest;
use Modules\Core\DTO\BaseDTO;

class ResetPasswordDTO extends BaseDTO
{
    public function __construct(
        public ?string $email,
        public ?string $password,
        public ?string $token,
    ) {
    }

    public static function fromRequest(ResetPasswordRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
            token: $request->validated('token'),
        );
    }
}
