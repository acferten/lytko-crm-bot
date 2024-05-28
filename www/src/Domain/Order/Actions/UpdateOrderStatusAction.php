<?php

namespace Domain\Order\Actions;

use Domain\Order\DataTransferObjects\OrderStatusData;
use Domain\Order\Models\Order;
use Domain\Order\Notifications\OrderStatusChangedNotification;

class UpdateOrderStatusAction
{
    public static function execute(OrderStatusData $data): Order
    {
        $data->order->status()->associate($data->status);

        $data->order->save();

        OrderStatusChangedNotification::send($data->order, auth()->user());

        return $data->order->refresh();
    }
}
