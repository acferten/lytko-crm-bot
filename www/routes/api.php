<?php

use App\Http\Telegram\Controllers\TelegramWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('telegram-webhook', TelegramWebhookController::class);

Route::post('test', \App\Http\Controllers\TestController::class);
