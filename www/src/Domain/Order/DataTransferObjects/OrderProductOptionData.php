<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Product\Models\Parameter;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class OrderProductOptionData extends Data
{
    public function __construct(
        public readonly Parameter  $parameter,
        public readonly Collection $options,
    )
    {
    }
}
