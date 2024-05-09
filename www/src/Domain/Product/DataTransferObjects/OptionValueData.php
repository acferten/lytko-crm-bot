<?php

namespace Domain\Product\DataTransferObjects;

use Spatie\LaravelData\Data;

class OptionValueData extends Data
{
    public function __construct(
        public readonly string $name,
    )
    {
    }

    public static function fromArray(array $data): OptionValueData
    {

        return new self(
            name: $data['name'],
        );
    }
}
