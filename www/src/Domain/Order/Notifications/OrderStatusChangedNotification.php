<?php

namespace Domain\Order\Notifications;

use Domain\Order\Models\Order;
use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class OrderStatusChangedNotification
{
    public static function send(Order $order): void
    {
        $recipients = User::role('administrator')->whereNotNull('telegram_id')->get();

        $text = "
            Статус заказа #{$order->id} был изменен.
            Новый статус: {$order->status->name}
        ";

        foreach ($recipients as $recipient) {
            Telegram::sendMessage($text, $recipient->telegram_id);
        }
    }
}
