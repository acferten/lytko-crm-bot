<?php

namespace Domain\Product\DataTransferObjects;

use Spatie\LaravelData\Data;

class ParameterData extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly ?array $options,
    ) {
    }

    public static function fromArray(array $data): ParameterData
    {
        return new self(
            title: $data['name'],
            options: $data['options']
        );
    }
}
