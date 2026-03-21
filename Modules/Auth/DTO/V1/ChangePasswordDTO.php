<?php

namespace Modules\Auth\DTO\V1;

use Modules\Auth\Requests\ChangePasswordRequest;
use Modules\Core\DTO\BaseDTO;


class ChangePasswordDTO extends BaseDTO
{
    public function __construct(
        public ?string $old_password,
        public ?string $new_password,
    ) {
    }

    public static function fromRequest(ChangePasswordRequest $request): self
    {
        return new self(
            old_password: $request->validated('old_password'),
            new_password: $request->validated('new_password'),
        );
    }
}
