<?php

namespace Modules\Product\DTO\V1;

use Modules\Product\Requests\V1\Product\CreateProductRequest;
use Modules\Product\Requests\V1\Product\UpdateProductRequest;
use Modules\Core\DTO\BaseDTO;

class ProductDTO extends BaseDTO
{
    public function __construct(
        public ?string $name_ar,
        public ?string $desc_ar,
        public ?string $name_en,
        public ?string $desc_en,
        public ?array $meta,
        public ?bool $is_active,
        public ?string $mpn,
        public ?string $gtin,
        public ?string $oem,
        public ?string $note,
        public ?string $category_id,

        public ?array $stocks,
    ) {
    }

    public static function fromRequest(CreateProductRequest|UpdateProductRequest $request): self
    {
        return new self(
            name_ar: $request->validated('name_ar'),
            desc_ar: $request->validated('desc_ar'),
            name_en: $request->validated('name_en'),
            desc_en: $request->validated('desc_en'),
            meta: $request->validated('meta'),
            is_active: $request->validated('is_active'),
            note: $request->validated('note'),
            mpn: $request->validated('mpn'),
            gtin: $request->validated('gtin'),
            oem: $request->validated('oem'),
            category_id: $request->validated('category_id'),

            stocks: array_map(fn($stock) => StockDTO::fromArray($stock), self::prepareRequestArray($request->validated('stocks'))),
        );
    }

}
