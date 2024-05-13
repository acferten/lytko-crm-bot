<?php

namespace Domain\Product\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $title
 * @property int $product_id
 * @property Product $product
 * @property Collection<Option> $options
 */
class Parameter extends BaseModel
{
    protected $fillable = [
        'product_id',
        'title',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class, 'parameter_id');
    }
}
