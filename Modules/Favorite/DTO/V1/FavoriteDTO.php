<?php

namespace Modules\Favorite\DTO\V1;

use Modules\Favorite\Requests\V1\Favorite\CreateFavoriteRequest;
use Modules\Favorite\Requests\V1\Favorite\UpdateFavoriteRequest;
use Modules\Core\DTO\BaseDTO;

class FavoriteDTO extends BaseDTO
{
    public function __construct(
        public ?string $user_id,
        public ?string $product_id,
    ) {
    }

    public static function fromRequest(CreateFavoriteRequest|UpdateFavoriteRequest $request): self
    {
        return new self(
            user_id: $request->validated('user_id'),
            product_id: $request->validated('product_id'),
        );
    }
}
