<?php

namespace Domain\Order\Telegram\Menu\Concerns;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Domain\Order\Notifications\OrderStatusChangedNotification;
use Domain\Shared\Models\User;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

trait UpdateOrderStatusTrait
{
    public function showChangeStatusMenu(Nutgram $bot): void
    {
        $this->clearButtons()->menuText('Вы хотите изменить статус заказа на',
            ['parse_mode' => 'html']);

        foreach (OrderStatus::all() as $status) {
            if (Order::find($bot->callbackQuery()->data)->status->id != $status->id) {
                $this->addButtonRow(InlineKeyboardButton::make($status->name,
                    callback_data: "{$status->id},{$bot->callbackQuery()->data}@changeStatus"));
            }
        }

        $this->addButtonRow(InlineKeyboardButton::make('◀️ Вернуться назад', callback_data: 'back@returnBack'))
            ->orNext('none')
            ->showMenu();
    }

    public function changeStatus(Nutgram $bot): void
    {
        $update_info = explode(',', $bot->callbackQuery()->data);

        $status = OrderStatus::find($update_info[0]);
        $order = Order::find($update_info[1]);

        $order->update(['status_id' => $status->id]);

        OrderStatusChangedNotification::send($order, User::where('telegram_id', $bot->userId())->first());

        $this->start($bot, $order->id);
    }
}
