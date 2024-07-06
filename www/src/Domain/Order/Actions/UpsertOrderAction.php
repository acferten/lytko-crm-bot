<?php

namespace Domain\Order\Actions;

use Domain\Order\DataTransferObjects\OrderData;
use Domain\Order\Models\Address;
use Domain\Order\Models\Order;
use Illuminate\Support\Facades\Log;

class UpsertOrderAction
{
    public static function execute(OrderData $data)
    {
        $order = Order::where(['wordpress_id' => $data->wordpress_id])->first();

        if ($order) {
            $order->update(
                [
                    'status_id' => $data->status->id,
                ]);
        } else {
            $order = Order::create(
                [
                    'status_id' => $data->status->id,
                    'user_id' => $data->user?->id,
                    'wordpress_id' => $data->wordpress_id,
                    'wordpress_post_id' => $data->wordpress_post_id,
                ]);

            foreach ($data->products as $product) {
                $order->products()->attach($product->product->id, ['quantity' => $product->quantity]);

                Log::debug($product->options->pluck('options')[0]->each(
                    function ($option) {
                        return $option->name;
                    }
                ));

                if ($product->options) {
                    $attached = $order->products()->find($product->product->id);
                    foreach ($product->options->pluck('options') as $option) {
                        $attached->pivot->options()->attach($option->first()?->id);
                    }
                }
            }

            $address = Address::create([...$data->address->all()]);
            $order->address()->associate($address->id);
            $order->save();
        }

        return $order->refresh()->load('address', 'products')->products->each(fn($product) => $product->pivot->load('options'));
    }
}
