<?php

namespace App\Http\Telegram\Controllers;

use Illuminate\Routing\Controller;
use SergiX44\Nutgram\Nutgram;

class TelegramWebhookController extends Controller
{
    /**
     * Handle the telegram webhook request.
     */
    public function __invoke(Nutgram $bot): void
    {
        $bot->run();
    }
}
