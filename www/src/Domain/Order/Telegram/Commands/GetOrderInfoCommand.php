<?php

namespace Domain\Order\Telegram\Commands;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class GetOrderInfoCommand extends Command
{
    protected string $command = 'order {id}';

    protected ?string $description = 'Получить инфу о заказе';

    public function handle(Nutgram $bot, int $id): void
    {
        $order = Order::findOrFail($id);

        OrderCardMessage::send($order, $bot->userId());
    }
}
