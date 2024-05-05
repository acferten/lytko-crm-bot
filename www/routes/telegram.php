<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Domain\Order\Telegram\Commands\GetOrderInfoCommand;
use Domain\Order\Telegram\Menu\GetAssignedOrdersMenu;
use Domain\User\Telegram\Menu\GetEmployeesMenu;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hello, world!');
})->description('The start command!');

$bot->onCommand('assigned', GetAssignedOrdersMenu::class)->description('Assigned orders');

$bot->onCommand('employees', GetEmployeesMenu::class)->description('Employees list');

$bot->registerCommand(GetOrderInfoCommand::class)->whereNumber('id');;


// Exceptions
if (env('APP_DEBUG')) {
    $bot->onException(function (Nutgram $bot, \Throwable $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage("File: " . $exception->getFile());
        $bot->sendMessage("Line: " . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
        Log::channel('telegram')->error($exception->getMessage());
    });

    $bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage("File: " . $exception->getFile());
        $bot->sendMessage("Line: " . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
        Log::channel('telegram')->error($exception->getMessage());
    });
}
