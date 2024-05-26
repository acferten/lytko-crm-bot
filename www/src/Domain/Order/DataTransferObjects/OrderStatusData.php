<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;

class OrderStatusData extends Data
{
    public function __construct(
        #[WithoutValidation]
        public readonly Order       $order,
        #[WithoutValidation]
        public readonly OrderStatus $status,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'status' => OrderStatus::find($request->input('status_id')),
            'order' => Order::find($request->order),
        ]);
    }

    public static function rules(): array
    {
        return [
            'status_id' => ['required', 'int', 'exists:order_statuses,id'],
        ];
    }
}
