<?php

namespace App\Http\Controllers;

use Domain\Shared\Services\Lytko\Client;
use Illuminate\Http\Request;

class TestController
{
    public function __construct(Client $client)
    {
        $this->lytko = $client;
    }

    public function __invoke(Request $request)
    {
        $this->lytko->users();
        $this->lytko->products();

        return $this->lytko->orders();
    }
}
