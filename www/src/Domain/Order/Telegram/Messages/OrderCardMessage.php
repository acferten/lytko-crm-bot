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
        $orderLink = "https://present-koi-vocal.ngrok-free.app/orders/{$order->id}"; //TODO: change

        $card = self::getCard($order);

        $markup = InlineKeyboardMarkup::make()
            ->addRow(InlineKeyboardButton::make('👀 Посмотреть заказ в WordPress', url: $order->getWordPressUrl()))
            ->addRow(InlineKeyboardButton::make('👀 Посмотреть заказ в CRM', url: $orderLink));

        Telegram::sendMessage($card, $user_id, parse_mode: 'html', reply_markup: $markup);
    }

    public static function getCard(Order $order): string
    {
        $card = "
<b>📦 ID: {$order->id}\n</b>
<b>📦 WordPress ID: {$order->wordpress_id}\n</b>
<b>📌 Статус: {$order->status->name}\n</b>
<b>✉️ Адрес доставки:</b>
{$order->address->name} {$order->address->surname}
{$order->address->company_name},
{$order->address->country}, {$order->address->state}, {$order->address->city}, {$order->address->address}
{$order->address->zip_code}
{$order->address->phone}\n{$order->address->email}\n";

        $card .= $order->address->telegram_username ? "Telegram: {$order->address->telegram_username}\n" : null;
        $card .= $order->address->note ? "\n<b>❗️Примечание к заказу:</b> \n{$order->address->note}" : null;
        $card .= $order->history ? "\n\n<b>💾 История:</b> {$order->history->name}\n" : null;
        $card .= $order->products ? "\n<b>🔧 Заказанные товары:</b>\n" : null;

        foreach ($order->products as $product) {
            $card .= "• {$product->name}\n";
        }

        return $card;
    }
}
