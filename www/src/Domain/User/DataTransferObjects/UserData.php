<?php

namespace Domain\User\DataTransferObjects;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly ?string $name,
        public readonly string $login,
        public readonly ?string $surname,
        public readonly string $role,
        public readonly string $password,
    ) {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $user): self
    {
        return new self(
            id: null,
            email: $user['email'],
            name: empty($user['first_name']) ? null : $user['first_name'],
            login: $user['username'],
            surname: empty($user['last_name']) ? null : $user['last_name'],
            role: $user['roles'][0],
            password: Str::password(10),
        );
    }
}
