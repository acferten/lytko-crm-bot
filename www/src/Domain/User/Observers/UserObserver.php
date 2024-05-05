<?php

namespace Domain\User\Observers;

use Domain\Shared\Models\User;
use Domain\Shared\Services\Lytko\Client;

class UserObserver
{
    protected $lytkoSevice;

    public function __construct(Client $client)
    {
        $this->lytkoSevice = $client;
    }

    public function retrieved(User $user): void
    {
        //
    }

    public function created(User $user): void
    {
        //
    }

    public function updated(User $user): void
    {
        //
    }

    public function deleted(User $user): void
    {
        //
    }

    public function restored(User $user): void
    {
        //
    }

    public function forceDeleted(User $user): void
    {
        //
    }
}
