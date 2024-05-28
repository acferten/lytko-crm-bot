<?php

namespace Domain\Order\Notifications;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class EmployeeAssignedToOrderNotification
{
    public static function send(User $user, Order $order): void
    {
        $text = "Вы были назначены на заказ #{$order->id}.\n\n";

        if ($user->telegram_id) {
            Telegram::sendMessage($text, $user->telegram_id, parse_mode: 'html');
            OrderCardMessage::send($order, $user->telegram_id);
        }
    }
}
