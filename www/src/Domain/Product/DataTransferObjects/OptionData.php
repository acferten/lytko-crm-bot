<?php

namespace Domain\Product\DataTransferObjects;

use Spatie\LaravelData\Data;

class OptionData extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly ?array $values,
    ) {
    }

    public static function fromArray(array $data): OptionData
    {
        return new self(
            title: $data['name'],
            values: $data['options']
        );
    }
}
