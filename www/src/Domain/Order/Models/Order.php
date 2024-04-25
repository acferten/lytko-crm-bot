<?php

namespace Domain\Order\Models;

use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $price
 */
class Order extends BaseModel
{
    protected $fillable = [
        'name',
        'price',
    ];
}
