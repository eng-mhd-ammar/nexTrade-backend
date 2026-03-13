<?php

namespace Modules\Auth\DTO\V1;

use Modules\Addresses\DTO\V1\AddressDTO;
use Modules\Auth\Requests\V1\Profile\UpdateProfileRequest;
use Modules\Core\DTO\BaseDTO;

class ProfileDTO extends BaseDTO
{
    public function __construct(
        public ?string $avatar,
        public ?string $first_name,
        public ?string $last_name,
        public ?bool $gender,
        public ?string $email,
        public ?string $password,
        public ?array $addresses,
    ) {
    }

    public static function fromRequest(UpdateProfileRequest $request): self
    {
        return new self(
            avatar: self::handleFileStoring($request->validated('avatar'), '/users_avatar'),
            first_name: $request->validated('first_name'),
            last_name: $request->validated('last_name'),
            gender: $request->validated('gender'),
            email: $request->validated('email'),
            password: $request->validated('password'),

            addresses: self::prepareRequestArray($request->validated('addresses')),
        );
    }
}
