<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->users();
})->everyMinute();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->products();
})->everyMinute();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->orders();
})->everyMinute();
