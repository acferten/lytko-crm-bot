<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Order\Models\OrderStatus;
use Spatie\LaravelData\Data;

class OrderProductsData extends Data
{
    public function __construct(
        public readonly ?string $name,
        public readonly OrderStatus $values,
    ) {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $order): self
    {

    }
}
