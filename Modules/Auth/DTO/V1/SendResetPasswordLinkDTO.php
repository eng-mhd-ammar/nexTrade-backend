<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Auth\SendResetPasswordLinkRequest;
use Modules\Core\DTO\BaseDTO;

class SendResetPasswordLinkDTO extends BaseDTO
{
    public function __construct(
        public ?string $email,
    ) {
    }

    public static function fromRequest(SendResetPasswordLinkRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
        );
    }
}
