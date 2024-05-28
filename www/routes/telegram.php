<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use Domain\Order\Telegram\Menu\AssignEmployeeToOrderMenu;
use Domain\Order\Telegram\Menu\GetAssignedOrdersMenu;
use Domain\Order\Telegram\Menu\ManageOrderInfoMenu;
use Domain\User\Telegram\Menu\GetEmployeesMenu;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

$bot->onCommand('orders', GetAssignedOrdersMenu::class)->description('Порученные заказы');

$bot->onCommand('assign', AssignEmployeeToOrderMenu::class)->description('Поручить сотруднику заказ');

$bot->onCommand('employees', GetEmployeesMenu::class)->description('Список сотрудников');

$bot->onCommand('order {order_id}', ManageOrderInfoMenu::class)->description('Информация о заказе (order id)');

// Exceptions
if (env('APP_DEBUG')) {
    $bot->onException(function (Nutgram $bot, \Throwable $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage('File: ' . $exception->getFile());
        $bot->sendMessage('Line: ' . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
        Log::channel('telegram')->error($exception->getMessage());
    });

    $bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage('File: ' . $exception->getFile());
        $bot->sendMessage('Line: ' . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
        Log::channel('telegram')->error($exception->getMessage());
    });
}
