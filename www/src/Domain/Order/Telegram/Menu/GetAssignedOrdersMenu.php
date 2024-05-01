<?php

namespace Domain\Order\Telegram\Menu;

use Domain\Order\Enums\OrderStatusEnum;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class GetAssignedOrdersMenu extends InlineMenu
{
    public Collection $orders;
    public int $page;

    public function start(Nutgram $bot): void
    {
        $employee = User::where('telegram_id', $bot->userId())->first();

        if (is_null($employee)) {
            $this->menuText('🚫 У Вас нет доступа к этой команде.')->showMenu();
            return;
        }

        $this->orders = $employee->assignments;

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

    public function showChangeStatusMenu(Nutgram $bot): void
    {
        $this->clearButtons()->menuText("Вы хотите изменить статус заказа на",
            ['parse_mode' => 'html']);

        foreach (OrderStatus::all() as $status) {
            if (Order::find($bot->callbackQuery()->data)->status->id != $status->id)
                $this->addButtonRow(InlineKeyboardButton::make($status->name,
                    callback_data: "{$status->name},{$bot->callbackQuery()->data}@changeStatus"));
        }

        $this->addButtonRow(InlineKeyboardButton::make("◀️ Вернуться назад", callback_data: "back@returnBack"))
            ->orNext('none')
            ->showMenu();
    }

    public function returnBack(Nutgram $bot): void
    {
        $this->getOrderLayout($bot);
    }

    public function changeStatus(Nutgram $bot): void
    {
        $update_info = explode(",", $bot->callbackQuery()->data);
        $status_name = $update_info[0];
        $order_id = $update_info[1];

        $status = OrderStatus::where('name', $status_name)->first();

        Order::find($order_id)->update(
            ['status_id' => $status->id]
        );

        $this->start($bot);
    }

    public function none(Nutgram $bot): void
    {
        $this->end();
    }
}
