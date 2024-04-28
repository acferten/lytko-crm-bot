<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Domain\Order\Telegram\Conversations\GetNewOrdersConversation;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;


$bot->onCommand('start', function (Nutgram $bot) {
    $bot->sendMessage('Hello, world!');
})->description('The start command!');

$bot->onCommand('new_orders', GetNewOrdersConversation::class);


// Exceptions
if (env('APP_DEBUG')) {
    $bot->onException(function (Nutgram $bot, \Throwable $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage("File: " . $exception->getFile());
        $bot->sendMessage("Line: " . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
    });

    $bot->onApiError(function (Nutgram $bot, TelegramException $exception) {
        $bot->sendMessage($exception->getMessage());
        $bot->sendMessage("File: " . $exception->getFile());
        $bot->sendMessage("Line: " . $exception->getLine());
        Log::channel('nutgram')->error($exception->getMessage());
    });
}
