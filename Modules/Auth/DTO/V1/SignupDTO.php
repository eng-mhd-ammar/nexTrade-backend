<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Auth\SignUpRequest;
use Modules\Core\DTO\BaseDTO;

class SignupDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?string $user_type_id,
        public ?array $addresses,
    ) {
    }

    public static function fromRequest(SignUpRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            user_type_id: $request->validated('user_type_id'),

            addresses: self::prepareRequestArray($request->validated('addresses')),
        );
    }
}
