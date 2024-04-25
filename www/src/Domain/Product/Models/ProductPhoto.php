<?php

namespace Domain\Product\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 */
class ProductPhoto extends BaseModel
{
    protected $fillable = [
        'product_id',
        'file'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
