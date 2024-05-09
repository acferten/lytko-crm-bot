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
                'name' => $data->name
            ],
            [
                ...$data->all(),
                'status_id' => 1
            ]);

        $product->photos()->createMany($data->photos->toArray());

        foreach ($data->options as $option) {
            $createdOption = $product->options()->create([...$option->toArray()]);

            foreach ($option->values as $value) {
                $createdOption->values()->create(['name' => $value]);
            }
        }

        return $product->refresh()->load('photos');
    }
}
