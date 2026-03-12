<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\V1\Role\CreateRoleRequest;
use Modules\Auth\Requests\V1\Role\UpdateRoleRequest;
use Modules\Core\DTO\BaseDTO;

class RoleDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
    ) {
    }

    public static function fromRequest(CreateRoleRequest|UpdateRoleRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
        );
    }
}
