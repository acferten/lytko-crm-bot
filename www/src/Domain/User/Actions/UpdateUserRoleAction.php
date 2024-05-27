<?php

namespace Domain\User\Actions;

use Domain\Shared\Models\User;
use Domain\User\DataTransferObjects\UserRoleData;

class UpdateUserRoleAction
{
    public static function execute(UserRoleData $data): User
    {
        $data->user->syncRoles([$data->role]);

        return $data->user->refresh();
    }
}
