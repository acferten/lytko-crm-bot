<?php

namespace Domain\Order\Actions;

use Domain\Order\DataTransferObjects\OrderStatusData;
use Domain\Order\Models\Order;

class UpdateOrderStatusAction
{
    public static function execute(OrderStatusData $data): Order
    {
        $data->order->status()->associate($data->status);

        $data->order->save();

        return $data->order->refresh();
    }
}
