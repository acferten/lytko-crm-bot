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
        $card = self::getCard($order);

        $markup = InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make('👨‍💼 Написать владельцу', url: 'https://vk.com'))
            ->addRow(InlineKeyboardButton::make('👨‍💼 Написать владельцу', url: 'https://vk.com'));

        if ($button_next) {
            $markup->addRow(InlineKeyboardButton::make('🔽 Следующий заказ', callback_data: 'next'));
        }

        Telegram::sendMessage($card, $user_id, parse_mode: 'html');
    }

    public static function getCard(Order $order): string
    {
        $card = "
<b>📦 ID: {$order->id}\n</b>
<b>📌 Статус: {$order->status->name}\n</b>
<b>✉️ Адрес доставки:</b>
{$order->address->name} {$order->address->surname}, {$order->address->company_name},
{$order->address->country}, {$order->address->state},{$order->address->city},{$order->address->street}, {$order->address->house_number}, {$order->address->zip_code},
{$order->address->phone}, {$order->address->email}, {$order->address->telegram_username},
Примечание к заказу: {$order->address->note}\n\n<b>🔧 Заказанные товары:</b>\n";

        foreach ($order->products as $product) {
            $card .= "• {$product->name}\n";
        }

        return $card;
    }
}
