<?php

namespace Domain\Order\Notifications;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class OrderStatusChangedNotification
{
    public static function send(Order $order): void
    {
        $recipients = User::role('administrator')->whereNotNull('telegram_id')->get();

        $text = "<b>❗️ Статус заказа</b> #{$order->id} был изменен.\n\n<b>📌 Новый статус</b>: {$order->status->name}";

        $text .= $order->history ? "\n\n<b>💾 История:</b> {$order->history->name}" : null;

        foreach ($recipients as $recipient) {
            if ($recipient->telegram_id) {
                Telegram::sendMessage($text, $recipient->telegram_id);
                OrderCardMessage::send($order, $recipient->telegram_id);
            }
        }
    }
}
