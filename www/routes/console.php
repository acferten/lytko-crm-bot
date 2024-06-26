<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->users();
})->everyFifteenMinutes();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->products();
})->everyFifteenMinutes();

Schedule::call(function (\Domain\Shared\Services\Lytko\Client $client) {
    $client->orders();
})->everyFifteenMinutes();
