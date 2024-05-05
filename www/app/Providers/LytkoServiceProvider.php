<?php

namespace App\Providers;

use Domain\Shared\Services\Lytko\Client;
use Illuminate\Support\ServiceProvider;

class LytkoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client(
                uri: config('services.lytko.uri'),
                username: config('services.lytko.username'),
                password: config('services.lytko.password'),
                timeout: config('services.lytko.timeout'),
                retryTimes: config('services.lytko.retry_times'),
                retryMilliseconds: config('services.lytko.retry_milliseconds'),
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
