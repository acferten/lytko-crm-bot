<?php

namespace Domain\User\DataTransferObjects;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly string $name,
        public readonly string $login,
        public readonly string $surname,
        public readonly string $role,
        public readonly string $password,
    ) {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            ...$request->all(),
        ]);
    }

    public static function fromResponse(array $user): self
    {
        return self::from([
            'name' => $user['first_name'],
            'surname' => $user['last_name'],
            'login' => $user['username'],
            'email' => $user['email'],
            'role' => $user['roles'][0],
            'password' => Str::password(10),
        ]);
    }
}
