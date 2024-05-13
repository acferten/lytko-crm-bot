<?php

namespace Domain\Order\Models;

use Domain\Product\Models\Option;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
    ];

    public function options(): belongsToMany
    {
        return $this->belongsToMany(Option::class,
            'order_product_option', 'order_product_id', 'option_id')
            ->withTimestamps();
    }
}
