<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Domain\Shared\Models\User;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public readonly ?int         $wordpress_id,
        public readonly OrderStatus  $status,
        public readonly ?User        $user,
        /** @var Collection<OrderProductData> */
        public readonly ?Collection  $products,
        public readonly ?AddressData $address,
    )
    {
    }

    public static function fromModel(Order $order): self
    {
        return self::from([
            ...$order->toArray(),
            'status' => $order->status,
            'user' => $order->user,
            'products' => $order->products->each(fn($product) => $product->pivot->options),
            'address' => $order->address,
        ]);
    }

    /**
     * Parse response from WordPress API
     */
    public static function fromResponse(array $order): self
    {
        $telegram_meta_key = array_search('telegram', array_column($order['meta_data'], 'key'));

        return new self(
            wordpress_id: $order['id'],
            status: OrderStatus::firstOrCreate(
                ['wordpress_slug' => $order['status']],
                ['slug' => $order['status'], 'status' => $order['status']]),
            user: User::where(['email' => $order['billing']['email']])->first(),
            products: OrderProductData::collect($order['line_items'], Collection::class),
            address: AddressData::from($order['billing'],
                $telegram_meta_key ? $order['meta_data'][$telegram_meta_key]['value'] : null),
        );
    }
}
