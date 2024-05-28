<?php

namespace App\Http\Web\Controllers\User;

use Domain\Order\Models\Order;
use Domain\Shared\Models\User;
use Domain\User\Actions\UpdateUserRoleAction;
use Domain\User\DataTransferObjects\UserRoleData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController
{
    public function index(): View
    {
        Gate::authorize('viewAny', User::class);

        if (auth()->user()->hasRole(['administrator'])) {
            $users = User::withoutRole('customer')->get();
        } else {
            $users = User::where('id', '=', auth()->user()->id)->get();
        }

        return view('pages.user.index', compact('users'));
    }

    public function edit(User $user): View
    {
        Gate::authorize('update', $user);

        $roles = Role::all();

        return view('pages.user.update', compact('user', 'roles'));
    }

    public function update(UserRoleData $data): RedirectResponse
    {
        Gate::authorize('update', $data->user);

        return redirect()->route('users.index', UpdateUserRoleAction::execute($data))
            ->with('success', "Роль сотрудника #{$data->user->id} успешно обновлена.");

    }
}
