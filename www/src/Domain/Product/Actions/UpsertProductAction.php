<?php

namespace Domain\Product\Actions;

use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\Models\Product;

class UpsertProductAction
{
    public static function execute(ProductData $data): Product
    {
        $product = Product::updateOrCreate(
            [
                'name' => $data->name,
            ],
            [
                ...$data->all(),
                'status_id' => 1,
            ]);

        $product->photos()->createMany($data->photos->toArray());

        foreach ($data->parameters as $parameter) {
            $createdParameter = $product->parameters()->create([...$parameter->toArray()]);

            foreach ($parameter->options as $option) {
                $createdParameter->options()->create(['name' => $option]);
            }
        }

        return $product->refresh()->load('photos');
    }
}
