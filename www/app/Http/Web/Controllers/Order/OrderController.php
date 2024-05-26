<?php

namespace App\Http\Web\Controllers\Order;

use Domain\Order\Actions\UpdateOrderStatusAction;
use Domain\Order\DataTransferObjects\OrderStatusData;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController
{
    public function index(): View
    {
        $orders = Order::all();

        return view('pages.order.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        return view('pages.order.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        $statuses = OrderStatus::all();

        return view('pages.order.update', compact('order', 'statuses'));
    }

    public function update(OrderStatusData $data): RedirectResponse
    {
        return redirect()->route('orders.show', UpdateOrderStatusAction::execute($data))
            ->with('success', 'Заказ успешно обновлен.');

    }
}
