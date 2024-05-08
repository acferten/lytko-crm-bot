<?php

namespace Domain\Product\DataTransferObjects;

use Spatie\LaravelData\Data;

class ProductPhotoData extends Data
{
    public function __construct(
        public readonly string $file,
    )
    {
    }

    public static function fromArray(array $data)
    {
        return new self(
            file: $data['src'],
        );
    }
}
