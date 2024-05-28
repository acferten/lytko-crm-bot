<?php

namespace Domain\Order\Policies;

use Domain\Order\Models\Order;
use Domain\Shared\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrator') || !$user->hasRole('customer');
    }

    public function view(User $user, Order $order): bool
    {
        return $user->hasRole('administrator') ||
            (!$user->hasRole('customer') && $user->assignments->contains($order));
    }


    public function update(User $user, Order $order): bool
    {
        return $user->hasRole('administrator') ||
            (!$user->hasRole('customer') && $user->assignments->contains($order));
    }

}
