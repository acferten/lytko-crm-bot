<?php

namespace Domain\User\Policies;

use Domain\Shared\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrator') ||
            (!$user->hasRole('customer'));
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasRole('administrator') ||
            (!$user->hasRole('customer') && $user->id === $model->id);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasRole('administrator') ||
            (!$user->hasRole('customer') && $user->id === $model->id);
    }
}
