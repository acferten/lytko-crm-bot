<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Order\Models\OrderStatus;
use Domain\Product\Models\Product;
use Domain\Shared\Models\User;
use Domain\Shared\Services\Lytko\Enums\LytkoOrderStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Optional;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public readonly null|int|Optional $id,
        public readonly ?int $wordpress_id,
        public readonly OrderStatus $status,
        public readonly ?User $user,
        public readonly ?Collection $products,
        public readonly ?AddressData $address,
    ) {
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $order): self
    {
        $product_names = array_column($order['line_items'], 'parent_name');
        $telegram_meta_key = array_search('telegram', array_column($order['meta_data'], 'key'));

        if (OrderStatus::where(
            ['slug' => LytkoOrderStatus::from($order['status'])->name]
        )->first() == null) {
            dd($order['status']);
        }

        return new self(
            id: null,
            wordpress_id: $order['id'],
            status: OrderStatus::where(
                ['slug' => LytkoOrderStatus::from($order['status'])->name]
            )->first(),
            user: User::where(['email' => $order['billing']['email']])->first(),
            products: Product::whereIn('name', $product_names)->get(),
            address: AddressData::from($order['billing'],
                $telegram_meta_key ? $order['meta_data'][$telegram_meta_key]['value'] : null),
        );
    }
}
