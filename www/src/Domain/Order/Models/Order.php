<?php

namespace Domain\Order\Models;

use Domain\Product\Models\Product;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $status_id
 * @property int $user_id
 * @property int $employee_id
 * @property Address $address
 * @property OrderStatus $status
 * @property Collection<Product> $products
 */
class Order extends BaseModel
{
    protected $fillable = [
        'user_id',
        'status_id',
        'employee_id',
        'address_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
