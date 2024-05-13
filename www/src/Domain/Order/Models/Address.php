<?php

namespace Domain\Order\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $company_name
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $street
 * @property string $house_number
 * @property string $zip_code
 * @property string $phone
 * @property string $email
 * @property string $telegram_username
 * @property string $note
 */
class Address extends BaseModel
{
    protected $fillable = [
        'name',
        'surname',
        'company_name',
        'country',
        'state',
        'city',
        'address',
        'address_2',
        'zip_code',
        'phone',
        'email',
        'telegram_username',
        'note',
    ];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class);
    }
}
