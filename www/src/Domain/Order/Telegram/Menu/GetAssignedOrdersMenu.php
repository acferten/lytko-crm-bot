<?php

namespace Domain\Order\Telegram\Menu;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderHistory;
use Domain\Order\Notifications\OrderStatusChangedNotification;
use Domain\Order\Telegram\Menu\Concerns\UpdateOrderHistoryTrait;
use Domain\Order\Telegram\Menu\Concerns\UpdateOrderStatusTrait;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class GetAssignedOrdersMenu extends InlineMenu
{
    use UpdateOrderStatusTrait;
    use UpdateOrderHistoryTrait;

    public Collection $orders;

    public int $page;

    public function start(Nutgram $bot): void
    {
        $employee = User::where('telegram_id', $bot->userId())->first();

        if (is_null($employee)) {
            $this->menuText('🚫 У Вас нет доступа к этой команде.')->showMenu();

            return;
        }

        if ($employee->hasRole('administrator')) {
            $this->orders = Order::orderBy('id', 'desc')->get();
        } else {
            $this->orders = $employee->assignments()->orderBy('id', 'desc')->get();
        }

        if ($this->orders->isEmpty()) {
            $this->menuText('😯 Пусто! Вам пока что не поручено ни одного нового заказа.')->showMenu();

            return;
        }

        $this->page = 0;
        $this->getOrderLayout($bot);
    }

    public function getOrderLayout(Nutgram $bot): void
    {
        // Current order
        $order = $this->orders->get($this->page);

        // Generating order card
        $total = count($this->orders);
        $currentPage = $this->page + 1;
        $card = "<b>Заказ {$currentPage} из {$total}</b>\n\n";
        $card .= OrderCardMessage::getCard($order);

        // Attaching order info
        $this->clearButtons()->menuText($card, ['parse_mode' => 'html']);

        $this->addButtonRow(InlineKeyboardButton::make('✍️ Изменить статус',
            callback_data: "{$order->id}@showChangeStatusMenu"));

        $this->addButtonRow(InlineKeyboardButton::make('💾 Добавить историю',
            callback_data: "{$order->id}@showChangeHistoryMenu"));

        // Pagination buttons
        if ($this->orders->get($this->page - 1)) {
            $this->addButtonRow(InlineKeyboardButton::make('◀️ Назад', callback_data: 'back@handlePagination'));
        }
        if ($this->orders->get($this->page + 1)) {
            $this->addButtonRow(InlineKeyboardButton::make('▶️ Далее', callback_data: 'next@handlePagination'));
        }

        // Updating menu message
        $this->orNext('none')
            ->showMenu();
    }

    public function handlePagination(Nutgram $bot): void
    {
        $this->page += $bot->callbackQuery()->data == 'next' ? 1 : -1;

        $this->getOrderLayout($bot);
    }

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

        $this->start($bot);
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
