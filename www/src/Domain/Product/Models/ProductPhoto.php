<?php

namespace Domain\Product\Models;

use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string $file
 * @property string $url
 */
class ProductPhoto extends BaseModel
{
    protected $fillable = [
        'product_id',
        'file',
        'url'
    ];

    public function getProductImage(): ?string
    {
        return $this->url ?? Storage::disk('')->url($this->file);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
