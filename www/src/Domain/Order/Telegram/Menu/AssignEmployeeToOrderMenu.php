<?php

namespace Domain\Order\Telegram\Menu;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Domain\Order\Notifications\EmployeeAssignedToOrderNotification;
use Domain\Order\Notifications\OrderStatusChangedNotification;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class AssignEmployeeToOrderMenu extends InlineMenu
{
    public Collection $orders;

    public int $page;

    public function start(Nutgram $bot): void
    {
        $employee = User::where('telegram_id', $bot->userId())->first();

        if (is_null($employee) || !$employee->hasRole('administrator')) {
            $this->menuText('🚫 У Вас нет доступа к этой команде.')->showMenu();

            return;
        }
        $this->orders = Order::whereNull('employee_id')->get();

        if ($this->orders->isEmpty()) {
            $this->menuText('😯 Пусто! Заказов без сотрудника нет.')->showMenu();

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

        $this->addButtonRow(InlineKeyboardButton::make('🧑 Поручить заказ сотруднику',
            callback_data: "{$order->id}@showEmployeesMenu"));

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

    public function showEmployeesMenu(Nutgram $bot): void
    {
        // $bot->callbackQuery()->data is order_id

        $this->clearButtons()->menuText('Поручить заказ сотруднику:',
            ['parse_mode' => 'html']);

        foreach (User::withoutRole('customer')->get() as $user) {
            if (User::where('telegram_id', $bot->userId())->first()->id != $user->id) {
                $this->addButtonRow(InlineKeyboardButton::make($user->getFullName(),
                    callback_data: "{$user->id},{$bot->callbackQuery()->data}@assignOrder"));
            }
        }

        $this->addButtonRow(InlineKeyboardButton::make('◀️ Вернуться назад', callback_data: 'back@returnBack'))
            ->orNext('none')
            ->showMenu();
    }

    public function returnBack(Nutgram $bot): void
    {
        $this->getOrderLayout($bot);
    }

    public function assignOrder(Nutgram $bot): void
    {
        $update_info = explode(',', $bot->callbackQuery()->data);
        $employee = User::find($update_info[0]);
        $order = Order::find($update_info[1]);

        $order->update(
            ['employee_id' => $employee->id]
        );

        EmployeeAssignedToOrderNotification::send($employee, $order);

        $this->start($bot);
    }

    public function none(Nutgram $bot): void
    {
        $this->end();
    }
}
