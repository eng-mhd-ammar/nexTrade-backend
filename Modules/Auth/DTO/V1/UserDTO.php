<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\User\CreateUserRequest;
use Modules\Auth\Requests\V1\User\UpdateUserRequest;
use Modules\Core\DTO\BaseDTO;

class UserDTO extends BaseDTO
{
    public function __construct(
        public ?string $avatar,
        public ?string $first_name,
        public ?string $last_name,
        public ?bool $gender,
        public ?string $email,
        public ?string $password,
        public ?string $user_type_id,
        public ?array $addresses,
    ) {
    }

    public static function fromRequest(CreateUserRequest|UpdateUserRequest $request): self
    {
        return new self(
            avatar: self::handleFileStoring($request->validated('avatar'), '/users_avatar'),
            first_name: $request->validated('first_name'),
            last_name: $request->validated('last_name'),
            gender: $request->validated('gender'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            user_type_id: $request->validated('user_type_id'),

            addresses: self::prepareRequestArray($request->validated('addresses')),
        );
    }
}
