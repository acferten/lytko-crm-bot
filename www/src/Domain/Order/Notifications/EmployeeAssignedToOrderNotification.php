<?php

namespace Domain\Order\Notifications;

use Domain\Order\Models\Order;
use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class EmployeeAssignedToOrderNotification
{
    public static function send(User $user, Order $order): void
    {
        $text = "
            Вы назначены на заказ #{$order->id}.
        ";

        if ($user->telegram_id) {
            Telegram::sendMessage($text, $user->telegram_id);
        }
    }
}
