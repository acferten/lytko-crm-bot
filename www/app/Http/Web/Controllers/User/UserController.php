<?php

namespace App\Http\Web\Controllers\User;

use Domain\Shared\Models\User;
use Domain\User\Actions\UpdateUserRoleAction;
use Domain\User\DataTransferObjects\UserRoleData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController
{
    public function index(): View
    {
        $data = [
            'users' => User::all()
        ];

        return view('pages.user.index', $data);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('pages.user.update', compact('user', 'roles'));
    }

    public function update(UserRoleData $data): RedirectResponse
    {
        return redirect()->route('users.index', UpdateUserRoleAction::execute($data))
            ->with('success', "Роль сотрудника #{$data->user->id} успешно обновлена.");

    }
}
