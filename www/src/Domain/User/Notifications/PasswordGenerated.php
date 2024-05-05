<?php

namespace Domain\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordGenerated extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $password
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Пароль сгенерирован')
            ->greeting("Приветствуем, $notifiable->name!")
            ->line("Ваш пароль для входа: {$this->password}");
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
