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
        $text = "
<b>🧑‍💻 {$user->name} {$user->surname} {$user->patronymic}</b>";

        $text .= $user->telegram_username ? "\n<b>💭 {$user->telegram_username} </b>\n" : "\n<b>💭 Telegram не указан </b>\n";

        $text .= "
<b>✏️ ID: {$user->id}</b>
<b>📌 Роль: {$user->getRoleNames()->first()}</b>
<b>✉️ {$user->email}</b>
";

        return $text;
    }
}
