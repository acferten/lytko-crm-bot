<?php

namespace Domain\Product\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $price
 */
class Product extends BaseModel
{
    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'status_id',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(Detail::class);
    }
}
