<?php

namespace Domain\Order\Observers;

use Domain\Order\Models\Order;
use Domain\Shared\Services\Lytko\Client;

class OrderObserver
{
    public function __construct(Client $client)
    {

    }

    public function updated(Order $order): void
    {
        //
    }
}
