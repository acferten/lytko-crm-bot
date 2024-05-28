<?php

namespace Domain\Shared\Models;

use Database\Factories\UserFactory;
use Domain\Order\Models\Order;
use Domain\User\Observers\UserObserver;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $patronymic
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $about
 * @property int $telegram_id
 * @property string $telegram_username
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements \Illuminate\Contracts\Auth\CanResetPassword, MustVerifyEmail
{
    use CanResetPassword;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'login',
        'email',
        'name',
        'surname',
        'patronymic',
        'telegram_id',
        'password',
        'telegram_username',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory()
    {
        return app(UserFactory::class);
    }


    public function getFullName(): string
    {
        return "{$this->surname} {$this->name} {$this->patronymic}";
    }

    public function getTelegramUrl(): string
    {
        return 'https://t.me/' . $this->telegram_username;
    }

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    // Orders for which the user with the employee role is responsible
    public function assignments(): hasMany
    {
        return $this->hasMany(Order::class, 'employee_id');
    }
}
