<?php

namespace Modules\Address\DTO\V1;

use Modules\Address\Requests\V1\Address\CreateAddressRequest;
use Modules\Address\Requests\V1\Address\UpdateAddressRequest;
use Modules\Core\DTO\BaseDTO;

class AddressDTO extends BaseDTO
{
    public function __construct(
        public ?string $name,
        public ?string $city,
        public ?string $street,
        public ?string $phone,
        public ?string $location_lat,
        public ?string $location_long,
    ) {
    }

    public static function fromRequest(CreateAddressRequest|UpdateAddressRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            city: $request->validated('city'),
            street: $request->validated('street'),
            phone: $request->validated('phone'),
            location_lat: $request->validated('location_lat'),
            location_long: $request->validated('location_long'),
        );
    }
}
