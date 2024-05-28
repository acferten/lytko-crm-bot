<?php

namespace Domain\Order\Telegram\Menu\Concerns;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderHistory;
use Domain\Order\Models\OrderStatus;
use Domain\Order\Notifications\OrderStatusChangedNotification;
use Domain\Shared\Models\User;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

trait UpdateOrderHistoryTrait
{
    public function showChangeHistoryMenu(Nutgram $bot): void
    {
        $this->clearButtons()->menuText('Вы хотите изменить историю заказа на',
            ['parse_mode' => 'html']);

        foreach (OrderHistory::all() as $history) {
            if (Order::find($bot->callbackQuery()->data)->history?->id != $history->id) {
                $this->addButtonRow(InlineKeyboardButton::make($history->name,
                    callback_data: "{$history->id},{$bot->callbackQuery()->data}@changeHistory"));
            }
        }

        $this->addButtonRow(InlineKeyboardButton::make('◀️ Вернуться назад', callback_data: 'back@returnBack'))
            ->orNext('none')
            ->showMenu();
    }

    public function changeHistory(Nutgram $bot): void
    {
        $update_info = explode(',', $bot->callbackQuery()->data);

        $history = OrderHistory::find($update_info[0]);
        $order = Order::find($update_info[1]);

        $order->history()->associate($history);
        $order->save();

        OrderStatusChangedNotification::send($order, User::where('telegram_id', $bot->userId())->first());

        $this->start($bot, $order->id);
    }
}
