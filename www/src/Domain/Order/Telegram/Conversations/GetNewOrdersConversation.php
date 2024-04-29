<?php

namespace Domain\Order\Telegram\Conversations;

use Domain\Order\Enums\OrderStatusEnum;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\InlineMenu;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;

class GetNewOrdersConversation extends InlineMenu
{
    public Collection $orders;
    public int $element;

    public function start(Nutgram $bot): void
    {
        $this->orders = OrderStatus::where('name', OrderStatusEnum::new->value)->first()->orders;

        if ($this->orders->isEmpty()) {
            $this->menuText('Новых заказов нет')->showMenu();
            return;
        }

        $this->element = 0;
        $this->getOrderLayout($bot);
    }

    public function handleNext(Nutgram $bot): void
    {
        $this->element += 1;
        $this->getOrderLayout($bot);
    }

    public function handleBack(Nutgram $bot): void
    {
        $this->element -= 1;
        $this->getOrderLayout($bot);
    }

    public function returnBack(Nutgram $bot): void
    {
        $this->getOrderLayout($bot);
    }

    public function handleChangeStatus(Nutgram $bot): void
    {
        $this->clearButtons()->menuText("Вы хотите изменить статус объекта на",
            ['parse_mode' => 'html']);

        foreach (OrderStatus::all() as $status) {
            if (Order::where(['id' => $bot->callbackQuery()->data])->first()->status->id != $status->id)
                $this->addButtonRow(InlineKeyboardButton::make($status->name,
                    callback_data: "{$status->name},{$bot->callbackQuery()->data}@handleChangeSelectedStatus"));

        }

        $this->addButtonRow(InlineKeyboardButton::make("◀️ Вернуться назад", callback_data: "back@returnBack"))
            ->orNext('none')
            ->showMenu();
    }

    public function handleChangeSelectedStatus(Nutgram $bot): void
    {
        $updateInfo = explode(",", $bot->callbackQuery()->data);
        $order = Order::findOrFail($updateInfo[1]);
        $status = OrderStatus::where('name', $updateInfo[0])->first();

        $order->status_id = $status->id;
        $order->save();

        $this->orders = OrderStatus::where('name', OrderStatusEnum::new->value)->first()->orders;

        if ($this->orders->isEmpty()) {
            $this->menuText('Новых заказов нет')->clearButtons()->showMenu();
            return;
        }

        $this->getOrderLayout($bot);
    }

    public function getOrderLayout(Nutgram $bot): void
    {
        $order = $this->orders[$this->element];
        $count = count($this->orders);
        $element = $this->element + 1;

        $bot->setUserData('user_posters_message_id', $this->messageId);

        $preview = "<b>Заказ {$element} из {$count}</b>\n\n {$order->id}";
        $this->clearButtons()->menuText($preview, ['parse_mode' => 'html']);

        $this->addButtonRow(InlineKeyboardButton::make('✍️ Изменить статус',
            callback_data: "{$order->id}@handleChangeStatus"));

        if (array_key_exists($this->element - 1, $this->orders->toArray())) {
            $this->addButtonRow(InlineKeyboardButton::make('◀️ Назад', callback_data: 'next@handleBack'));
        }

        if (array_key_exists($this->element + 1, $this->orders->toArray())) {
            $this->addButtonRow(InlineKeyboardButton::make('▶️ Далее', callback_data: 'next@handleNext'));
        }

        $this->orNext('none')
            ->showMenu();
    }

    public function none(Nutgram $bot): void
    {
        $bot->sendMessage('Вы вышли из просмотра новых заказов.');
        $this->end();
    }
}
