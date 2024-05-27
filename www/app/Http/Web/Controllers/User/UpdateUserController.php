<?php

namespace App\Http\Web\Controllers\User;

use Domain\Shared\Models\User;
use Domain\User\DataTransferObjects\UpdateUserData;
use Illuminate\Http\RedirectResponse;

class UpdateUserController
{
    public function __invoke(UpdateUserData $data, User $user): RedirectResponse
    {
        $user->update([
            ...$data->all()
        ]);

        return redirect()->route('users.index', $user)
            ->with('success', "Данные сотрудника #{$user->id} успешно обновлены.");
    }
}
