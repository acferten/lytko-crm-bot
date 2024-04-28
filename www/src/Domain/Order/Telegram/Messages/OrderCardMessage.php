<?php

namespace Domain\Order\Telegram\Messages;

use Domain\Order\Models\Order;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;


class OrderCardMessage
{
    public static function send(Order $order, int $user_id, bool $button_next = false): void
    {
        $card = "
        <b>Заказ {$order->id}</b>\n
Статус: {$order->status->name}
        ";

        $markup = InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make('👨‍💼 Написать владельцу', url: 'https://vk.com'))
            ->addRow(InlineKeyboardButton::make('👨‍💼 Написать владельцу', url: 'https://vk.com'));

        if ($button_next) {
            $markup->addRow(InlineKeyboardButton::make('🔽 Следующий заказ', callback_data: 'next'));
        }

        Telegram::sendMessage($card, $user_id, parse_mode: "HTML", reply_markup: $markup);
    }
}
