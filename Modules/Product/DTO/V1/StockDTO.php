<?php

namespace Modules\Product\DTO\V1;

use Modules\Product\Requests\V1\Stock\CreateStockRequest;
use Modules\Product\Requests\V1\Stock\UpdateStockRequest;
use Modules\Core\DTO\BaseDTO;

class StockDTO extends BaseDTO
{
    public function __construct(
        public ?string $id,
        public ?string $name_ar,
        public ?string $desc_ar,
        public ?string $name_en,
        public ?string $desc_en,
        public ?float $price,
        public ?int $quantity,
        public ?float $weight,
        public ?string $sku,
        public ?array $images,
        public ?array $attributes,
        public ?string $product_id,
    ) {
    }

    public static function fromRequest(CreateStockRequest|UpdateStockRequest $request): self
    {
        return new self(
            id: $request->validated('id'),
            name_ar: $request->validated('name_ar'),
            desc_ar: $request->validated('desc_ar'),
            name_en: $request->validated('name_en'),
            desc_en: $request->validated('desc_en'),
            price: $request->validated('price'),
            quantity: $request->validated('quantity'),
            weight: $request->validated('weight'),
            sku: $request->validated('sku'),
            images: self::prepareImagesFromArray($request->validated('images')),
            attributes: $request->validated('attributes'),
            product_id: $request->validated('product_id'),
        );
    }

    public static function fromArray(array|null $data): ?self
    {
        if (is_null($data)) return null;
        return new self(
            id: $data['id'] ?? null,
            name_ar: $data['name_ar'] ?? null,
            desc_ar: $data['desc_ar'] ?? 0,
            name_en: $data['name_en'] ?? null,
            desc_en: $data['desc_en'] ?? null,
            price: $data['price'] ?? false,
            quantity: $data['quantity'] ?? false,
            weight: $data['weight'] ?? false,
            sku: $data['sku'] ?? null,
            product_id: $data['product_id'] ?? null,
            images: self::prepareImagesFromArray($data['images'] ?? []),
            attributes: $data['attributes'] ?? [],
        );
    }

    protected static function prepareImagesFromArray(array $images): array
    {
        [$photos, $videos] = self::separateImagesAndVideos($images);

        $finalImages = self::prioritizeVideo($photos, $videos);

        return array_map(function ($image) {
            return $image instanceof \Illuminate\Http\UploadedFile
                ? self::handleFileStoring($image, '/products')
                : str_replace(env('APP_URL'), '', $image);
        }, $finalImages);
    }

    protected static function separateImagesAndVideos(array $images): array
    {
        $photos = [];
        $videos = [];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'mkv', 'flv', 'webm', 'mpg', '3gp'];

        foreach ($images as $image) {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $mimeType = $image->getMimeType();
                if (str_starts_with($mimeType, 'video/')) {
                    $videos[] = $image;
                } elseif (str_starts_with($mimeType, 'image/')) {
                    $photos[] = $image;
                }
            } elseif (is_string($image)) {
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if (in_array($extension, $videoExtensions)) {
                    $videos[] = $image;
                } else {
                    $photos[] = $image;
                }
            }
        }

        return [$photos, $videos];
    }

    protected static function prioritizeVideo(array $photos, array $videos): array
    {
        return !empty($videos)
            ? array_merge($photos, [$videos[0]])
            : $photos;
    }
}
