<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Auth\LoginRequest;
use Modules\Core\DTO\BaseDTO;

class LoginDTO extends BaseDTO
{
    public function __construct(
        public ?string $email,
        public ?string $password,
    ) {
    }

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
    public function getLoginFieldValue()
    {
        return $this->email;
    }
}
