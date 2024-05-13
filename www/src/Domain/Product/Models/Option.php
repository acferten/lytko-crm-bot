<?php

namespace Domain\Product\Models;

use Domain\Order\Models\OrderProduct;
use Domain\Shared\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $parameter_id
 * @property Parameter $parameter
 */
class Option extends BaseModel
{
    protected $fillable = [
        'parameter_id',
        'name',
    ];

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }

    public function orderProducts(): belongsToMany
    {
        return $this->belongsToMany(OrderProduct::class,
            'order_product_option', 'option_id', 'order_product_id');
    }
}
