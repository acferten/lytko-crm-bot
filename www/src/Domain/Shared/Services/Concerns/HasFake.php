<?php

namespace Domain\Shared\Services\Concerns;

use Illuminate\Support\Facades\Http;

trait HasFake
{
    /**
     * Proxies a fake call to Illuminate\Http\Client\Factory::fake()
     */
    public static function fake(null|callable|array $callback = null): void
    {
        Http::fake($callback);
    }
}
