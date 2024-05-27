<?php

namespace Domain\Order\DataTransferObjects;

use Domain\Order\Models\Order;
use Domain\Order\Models\OrderHistory;
use Domain\Order\Models\OrderStatus;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;

class OrderHistoryData extends Data
{
    public function __construct(
        #[WithoutValidation]
        public readonly Order        $order,
        #[WithoutValidation]
        public readonly OrderHistory $history,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return self::from([
            'history' => OrderHistory::find($request->input('history_id')),
            'order' => Order::find($request->order),
        ]);
    }

    public static function rules(): array
    {
        return [
            'history_id' => ['required', 'int', 'exists:order_histories,id'],
        ];
    }
}
