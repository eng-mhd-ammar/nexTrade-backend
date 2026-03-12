<?php

namespace Modules\Auth\DTO\V1;

use Modules\Core\DTO\BaseDTO;

class UserTypeDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
    ) {
    }

    public static function fromRequest(CreateUserTypeRequest|UpdateUserTypeRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
        );
    }
}
