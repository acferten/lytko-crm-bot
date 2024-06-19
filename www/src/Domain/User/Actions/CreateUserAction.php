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
        $user = User::where('email', $data->email)->first();

        if ($user) {
            $user->update([
                'name' => $data->name,
                'surname' => $data->surname,
                'email' => $data->email,
                'login' => $data->login,
            ]);
        } else {
            $user = User::create(
                [
                    'email' => $data->email,
                    'name' => $data->name,
                    'surname' => $data->surname,
                    'login' => $data->login,
                    'password' => Hash::make($data->password),
                ]);

            if ($data->role != 'customer') {
                $user->notify(new PasswordGenerated($data->password));
            }
        }

        $user->assignRole($data->role);

        return $user;
    }
}
