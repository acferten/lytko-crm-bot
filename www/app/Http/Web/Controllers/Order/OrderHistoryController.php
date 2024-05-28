<?php

namespace App\Http\Web\Controllers\Order;

use Domain\Order\Actions\UpdateOrderHistoryAction;
use Domain\Order\DataTransferObjects\OrderHistoryData;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderHistoryController
{
    public function edit(Order $order): View
    {
        $histories = OrderHistory::all();

        return view('pages.order.update-history', compact('order', 'histories'));
    }

    public function update(OrderHistoryData $data): RedirectResponse
    {
        return redirect()->route('orders.show', UpdateOrderHistoryAction::execute($data))
            ->with('success', 'Заказ успешно обновлен.');

    }
}
