<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Product\Models\Parameter;
use Domain\Product\Models\Product;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class OrderProductData extends Data
{
    public function __construct(
        public readonly Product     $product,
        /** @var Collection<OrderProductOptionData> */
        public readonly ?Collection $options,
        public readonly int         $quantity,
    )
    {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $orderProduct): self
    {
        $product = Product::where(['wordpress_id' => $orderProduct['product_id']])->first();

        if (!$product) {
            dd($orderProduct);
        }

        $options = new Collection();
        foreach ($orderProduct['meta_data'] as $option) {
            $parameter = Parameter::where(['title' => $option['display_key'], 'product_id' => $product->id])->first();

            if ($parameter) {
                $options->add(
                    item: OrderProductOptionData::from([
                        'parameter' => $parameter,
                        'options' => $parameter->options()->where('name', $option['display_value'])->get()
                    ])
                );
            }
        }

        return new self(
            product: $product,
            options: $options,
            quantity: $orderProduct['quantity']
        );
    }
}
