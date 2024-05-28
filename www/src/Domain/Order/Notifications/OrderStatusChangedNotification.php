<?php

namespace Domain\Order\Notifications;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class OrderStatusChangedNotification
{
    public static function send(Order $order, User $user): void
    {
        $recipients = User::role('administrator')->whereNotNull('telegram_id')->whereNot('id', $user->id)->get();

        $text = "<b>❗️Статус заказа</b> #{$order->id} был изменен пользователем #{$user->id}.\n\n<b>📌 Новый статус</b>: {$order->status->name}";

        $text .= $order->history ? "\n\n<b>💾 История:</b> {$order->history->name}" : null;

        foreach ($recipients as $recipient) {
            if ($recipient->telegram_id) {
                Telegram::sendMessage($text, $recipient->telegram_id, parse_mode: 'html');
                OrderCardMessage::send($order, $recipient->telegram_id);
            }
        }
    }
}
