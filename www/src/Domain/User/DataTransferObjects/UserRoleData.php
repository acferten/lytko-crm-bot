<?php

namespace Domain\User\DataTransferObjects;

use Domain\Shared\Models\User;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;
use Spatie\Permission\Models\Role;

class UserRoleData extends Data
{
    public function __construct(
        #[WithoutValidation]
        public readonly User $user,
        #[WithoutValidation]
        public readonly Role $role,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'role' => Role::find($request->input('role_id')),
            'user' => User::find($request->user),
        ]);
    }

    public static function rules(): array
    {
        return [
            'role_id' => ['required', 'int', 'exists:roles,id'],
        ];
    }
}
