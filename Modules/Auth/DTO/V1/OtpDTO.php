<?php

namespace Modules\Auth\DTO\V1;

use Modules\Core\DTO\BaseDTO;
use Modules\Auth\Requests\V1\Auth\OtpRequest;

class OtpDTO extends BaseDTO
{
    public function __construct(
        public ?string $code,
        public ?string $phone,
        public ?string $email,
    ) {
    }

    public static function fromRequest(OtpRequest $request): self
    {
        return new self(
            phone: $request->validated('phone'),
            email: $request->validated('email'),
            code: $request->validated('code'),
        );
    }
}
