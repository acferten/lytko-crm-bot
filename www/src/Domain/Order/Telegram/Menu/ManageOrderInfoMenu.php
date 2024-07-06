<?php

namespace Domain\Order\Telegram\Menu;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Menu\Concerns\UpdateOrderHistoryTrait;
use Domain\Order\Telegram\Menu\Concerns\UpdateOrderStatusTrait;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class ManageOrderInfoMenu extends InlineMenu
{
    use UpdateOrderStatusTrait;
    use UpdateOrderHistoryTrait;

    public ?Order $order;

    public function start(Nutgram $bot, int $order_id = null): void
    {
        $employee = User::where('telegram_id', $bot->userId())->first();

        if (is_null($employee) || $employee->hasRole('customer') || !($employee->hasRole('administrator') || $employee->assignments->contains($order))) {
            $bot->sendMessage('🚫 У Вас нет доступа к этой команде.');

            return;
        }

        if (!$order_id) {
            $bot->sendMessage('🤓 Введите номер заказа через пробел. Пример: /order 1');

            return;
        }

        $this->order = Order::where('wordpress_id', $order_id)->first();

        if (!$this->order) {
            $bot->sendMessage('🚫 Неверный ID заказа.');

            return;
        }

        $this->getOrderLayout($bot);
    }

    public function getOrderLayout(Nutgram $bot): void
    {
        // Current order
        $card = OrderCardMessage::getCard($this->order);
        $orderLink = "https://present-koi-vocal.ngrok-free.app/orders/{$this->order->id}"; //TODO: change

        // Attaching order info
        $this->clearButtons()->menuText($card, ['parse_mode' => 'html']);

        $this->addButtonRow(InlineKeyboardButton::make('👀 Посмотреть заказ в CRM',
            url: $orderLink));

        $this->addButtonRow(InlineKeyboardButton::make('👀 Посмотреть заказ в WordPress',
            url: $this->order->getWordPressUrl()));

        $this->addButtonRow(InlineKeyboardButton::make('✍️ Изменить статус',
            callback_data: "{$this->order->id}@showChangeStatusMenu"));

        $this->addButtonRow(InlineKeyboardButton::make('💾 Добавить историю',
            callback_data: "{$this->order->id}@showChangeHistoryMenu"));

        // Updating menu message
        $this->orNext('none')
            ->showMenu();
    }


    public function returnBack(Nutgram $bot): void
    {
        $this->getOrderLayout($bot);
    }

    public function none(Nutgram $bot): void
    {
        $this->end();
    }
}
