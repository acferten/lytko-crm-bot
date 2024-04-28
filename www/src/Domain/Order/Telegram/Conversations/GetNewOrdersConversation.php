<?php

namespace Domain\Order\Telegram\Conversations;

use Domain\Order\Enums\OrderStatusEnum;
use Domain\Order\Models\OrderStatus;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Illuminate\Support\Collection;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class GetNewOrdersConversation extends Conversation
{
    public Collection $orders;
    public int $element;

    public function start(Nutgram $bot): void
    {
        $orders = OrderStatus::where('name', OrderStatusEnum::new->value)->first()->orders;

        if ($orders->isEmpty()) {
            $bot->sendMessage(
                text: '😮 Пусто! Новых заказов пока что нет. ',
            );
            return;
        }

        $this->orders = $orders;

        $this->element = 0;
        if (array_key_exists($this->element + 1, $this->orders->toArray())) {
            $this->getOrderLayout($bot);
        } else {
            $this->getLastOrderLayout($bot);
        }
    }

    public function handleNext(Nutgram $bot): void
    {
        if (!$bot->isCallbackQuery()) {
            $this->getorderLayout($bot);
            return;
        }
        if ($bot->callbackQuery()->data == 'next') {
            $bot->answerCallbackQuery();
            $this->element += 1;

            if (array_key_exists($this->element + 1, $this->orders->toArray())) {
                $this->getorderLayout($bot);
            } else {
                $this->getLastorderLayout($bot);
            }
        }
    }

    public function getOrderLayout(Nutgram $bot): void
    {
        $order = $this->orders[$this->element];

        $order->update([
            'views' => $order->views + 1
        ]);

        OrderCardMessage::send($order, $bot->userId(), true);

        $this->next('handleNext');
    }

    public function getLastOrderLayout(Nutgram $bot): void
    {
        $order = $this->orders[$this->element];

        $order->update([
            'views' => $order->views + 1
        ]);

        OrderCardMessage::send($order, $bot->userId());

        $this->end();
    }

    public function none(Nutgram $bot): void
    {
        $bot->sendMessage('Bye!');
        $this->end();
    }
}
