<?php

namespace Domain\User\Telegram\Messages;

use Domain\Shared\Models\User;
use Nutgram\Laravel\Facades\Telegram;

class EmployeeCardMessage
{
    public static function send(User $user, int $user_id, bool $button_next = false): void
    {
        $card = self::getCard($user);

        Telegram::sendMessage($card, $user_id, parse_mode: 'html');
    }

    public static function getCard(User $user): string
    {
        return "
<b>🧑‍💻 {$user->name} {$user->surname} {$user->patronymic}</b>
<b>💭 {$user->telegram_username}</b>\n
<b>✏️ ID: {$user->id}</b>
<b>📌 Роль: {$user->getRoleNames()->first()}</b>
<b>✉️ {$user->email}</b>
";
    }
}
