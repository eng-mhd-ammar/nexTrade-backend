<?php

namespace Modules\Auth\DTO\V1;

use Modules\Addresses\DTO\V1\AddressDTO;
use Modules\Auth\Requests\V1\Profile\UpdateProfileRequest;
use Modules\Core\DTO\BaseDTO;

class ProfileDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
        public ?string $email,
        public ?string $password,
        public ?array $addresses,
    ) {
    }

    public static function fromRequest(UpdateProfileRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),

            addresses: self::prepareRequestArray($request->validated('addresses')),
        );
    }
}
