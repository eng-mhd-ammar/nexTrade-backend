<?php

namespace Modules\Address\DTO\V1;

use Modules\Address\Requests\V1\Address\CreateAddressRequest;
use Modules\Address\Requests\V1\Address\UpdateAddressRequest;
use Modules\Core\DTO\BaseDTO;

class AddressDTO extends BaseDTO
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

    public static function fromRequest(CreateAddressRequest|UpdateAddressRequest $request): self
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
