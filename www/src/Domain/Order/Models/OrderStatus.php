<?php

namespace Domain\Order\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $wordpress_slug
 */
class OrderStatus extends BaseModel
{
    protected $fillable = [
        'name',
        'slug',
        'wordpress_slug'
    ];

    public function orders(): hasMany
    {
        return $this->hasMany(Order::class, 'status_id');
    }
}
