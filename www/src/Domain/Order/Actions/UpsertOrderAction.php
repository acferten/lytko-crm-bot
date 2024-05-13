<?php

namespace Domain\Order\Actions;

use Domain\Order\DataTransferObjects\OrderData;
use Domain\Order\Models\Address;
use Domain\Order\Models\Order;

class UpsertOrderAction
{
    public static function execute(OrderData $data): Order
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
                ]);

            $order->products()->attach($data->products->pluck('id'), ['value_id' => 1, 'quantity' => 1]);
            $address = Address::create([...$data->address->all()]);
            $order->address()->associate($address->id);
            $order->save();
        }

        return $order->refresh()->load('address', 'products');
    }
}
