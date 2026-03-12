<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Auth\SendCodeRequest;
use Modules\Core\DTO\BaseDTO;

class CodeDTO extends BaseDTO
{
    public function __construct(
        public ?string $phone,
        public ?string $email,
    ) {
    }

    public static function fromRequest(SendCodeRequest $request): self
    {
        return new self(
            phone: $request->validated('phone'),
            email: $request->validated('email'),
        );
    }
}
