<?php

namespace Domain\User\Actions;

use Domain\Shared\Models\User;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Notifications\PasswordGenerated;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public static function execute(UserData $data): User
    {
        $user = User::updateOrCreate(
            [
                'email' => $data->email
            ],
            [
                'name' => $data->name,
                'surname' => $data->surname,
                'email' => $data->email,
                'login' => $data->login,
                'password' => Hash::make($data->password),
            ]);

        $user->notify(new PasswordGenerated($data->password));

        $user->assignRole($data->role);

        return $user;
    }
}
