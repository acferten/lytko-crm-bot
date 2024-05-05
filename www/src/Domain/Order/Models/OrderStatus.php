<?php

namespace Domain\Order\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class OrderStatus extends BaseModel
{
    protected $fillable = [
        'name',
    ];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
