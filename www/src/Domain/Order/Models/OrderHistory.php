<?php

namespace Domain\Order\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class OrderHistory extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class, 'history_id');
    }
}
