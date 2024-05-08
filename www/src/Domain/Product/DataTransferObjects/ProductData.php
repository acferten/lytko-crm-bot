<?php

namespace Domain\Product\DataTransferObjects;

use Illuminate\Support\Facades\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class ProductData extends Data
{
    public function __construct(
        public readonly ?int    $id,
        public readonly string  $name,
        public readonly string  $short_description,
        public readonly ?string $description,
        public readonly string  $price,
        /** @var DataCollection<ProductPhotoData> */
        public readonly ?DataCollection $photos,
        /** @var DataCollection<OptionData> */
        public readonly ?DataCollection $options,
    )
    {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $product): self
    {
        return new self(
            id: null,
            name: $product['name'],
            short_description: $product['short_description'],
            description: $product['description'],
            price: $product['price'],
            photos: ProductPhotoData::collect($product['images'], DataCollection::class),
            options: OptionData::collect($product['attributes'], DataCollection::class),
        );
    }
}
