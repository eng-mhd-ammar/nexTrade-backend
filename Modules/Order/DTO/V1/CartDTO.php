<?php

namespace Modules\Order\DTO\V1;

use Modules\Order\Requests\V1\Cart\CreateCartRequest;
use Modules\Order\Requests\V1\Cart\UpdateCartRequest;
use Modules\Core\DTO\BaseDTO;

class CartDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
        public ?string $country,
        public ?string $state,
        public ?string $city,
        public ?string $street,
        public ?string $phone,
        public ?array $coordinates,
        public ?string $details,
    ) {
    }

    public static function fromRequest(CreateCartRequest|UpdateCartRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            country: $request->validated('country'),
            state: $request->validated('state'),
            city: $request->validated('city'),
            street: $request->validated('street'),
            phone: $request->validated('phone'),
            coordinates: [
                "lat" => $request->validated('lat'),
                "lng" => $request->validated('lng')
            ],
            details: $request->validated('details'),
        );
    }
}
