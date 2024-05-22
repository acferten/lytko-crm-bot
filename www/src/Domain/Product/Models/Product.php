<?php

namespace Domain\Product\Models;

use Domain\Order\Models\Order;
use Domain\Product\Observers\ProductObserver;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $price
 */
#[ObservedBy([ProductObserver::class])]
class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'status_id',
        'wordpress_id'
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function parameters(): HasMany
    {
        return $this->hasMany(Parameter::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'value_id');
    }
}
