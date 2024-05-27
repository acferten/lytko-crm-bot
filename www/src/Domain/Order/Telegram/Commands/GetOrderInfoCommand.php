<?php

namespace Domain\Order\Telegram\Commands;

use Domain\Order\Models\Order;
use Domain\Order\Telegram\Messages\OrderCardMessage;
use Domain\Shared\Models\User;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class GetOrderInfoCommand extends Command
{
    protected string $command = 'order {id}';

    protected ?string $description = 'Get order information';

    public function handle(Nutgram $bot, int $id): void
    {
        $employee = User::where('telegram_id', $bot->userId())->first();

        $order = Order::find($id);

        if (is_null($employee) || $employee->hasRole('customer') || !$employee->hasRole('administrator') || $employee->assignments->doesntContain($order)) {
            $bot->sendMessage('🚫 У Вас нет доступа к этой команде.');

            return;
        }

        if (!$order) {
            $bot->sendMessage('🚫 Неверный ID заказа.');

            return;
        }

        OrderCardMessage::send($order, $bot->userId());
    }
}
