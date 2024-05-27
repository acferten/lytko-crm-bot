<?php

namespace Domain\User\DataTransferObjects;

use Illuminate\Support\Str;
use Spatie\LaravelData\Data;

class UpdateUserData extends Data
{
    public function __construct(
        public readonly int    $telegram_id,
        public readonly string $telegram_username,
    )
    {
    }
}
