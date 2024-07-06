<?php

namespace Domain\Order\Models;

use Domain\Order\Observers\OrderObserver;
use Domain\Product\Models\Product;
use Domain\Shared\Models\BaseModel;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

/**
 * @property int $id
 * @property int $status_id
 * @property int $user_id
 * @property int $employee_id
 * @property int $wordpress_id
 * @property Address $address
 * @property OrderStatus $status
 * @property OrderHistory $history
 * @property Collection<Product> $products
 */
#[ObservedBy([OrderObserver::class])]
class Order extends BaseModel
{
    use FilterQueryString;

    protected $filters = ['sort', 'search'];

    protected $fillable = [
        'user_id',
        'status_id',
        'employee_id',
        'address_id',
        'wordpress_id',
        'wordpress_post_id',
        'history_id'
    ];

    public function getWordPressUrl()
    {
        return "https://lytko.com/wp-admin/post.php?post={$this->wordpress_id}&action=edit";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function history(): BelongsTo
    {
        return $this->belongsTo(OrderHistory::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'id')
            ->using(OrderProduct::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function search($query, $value)
    {
        if (is_int($value)) {
            return $query->orWhere('wordpress_id', $value)
                ->orWhere('id', $value);
        }

        return $query->orWhereHas('status', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
        })->orWhereHas('employee', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%")->orWhere('surname', 'like', "%{$value}%");
        })->orWhereHas('user', function ($q) use ($value) {
            $q->where('name', 'like', "%{$value}%")->orWhere('surname', 'like', "%{$value}%");
        });
    }
}
