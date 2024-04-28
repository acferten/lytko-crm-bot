<?php

namespace Domain\Shared\Models;

use Database\Factories\UserFactory;
use Domain\Order\Models\Order;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $about
 * @property string $profile_picture
 */
class User extends Authenticatable implements \Illuminate\Contracts\Auth\CanResetPassword, MustVerifyEmail
{
    use CanResetPassword;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $fillable = [
        'login',
        'email',
        'password',
        'name',
        'surname',
        'patronymic',
        'telegram_id',
        'telegram_username',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory()
    {
        return app(UserFactory::class);
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
