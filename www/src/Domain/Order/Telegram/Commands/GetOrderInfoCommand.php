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

        if (is_null($employee) || $employee->hasRole('customer')) {
            $this->menuText('🚫 У Вас нет доступа к этой команде.')->showMenu();

            return;
        }

        $order = Order::findOrFail($id);

        OrderCardMessage::send($order, $bot->userId());
    }
}
