<?php

namespace Domain\Order\Actions;

use Domain\Order\DataTransferObjects\OrderHistoryData;
use Domain\Order\Models\Order;
use Domain\Order\Notifications\OrderStatusChangedNotification;

class UpdateOrderHistoryAction
{
    public static function execute(OrderHistoryData $data): Order
    {
        $data->order->history()->associate($data->history);

        $data->order->save();

        OrderStatusChangedNotification::send($data->order);

        return $data->order->refresh();
    }
}
