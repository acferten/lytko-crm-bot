<?php

namespace App\Http\Web\Controllers\Order;

use Domain\Order\Actions\UpdateOrderStatusAction;
use Domain\Order\DataTransferObjects\OrderStatusData;
use Domain\Order\Models\Order;
use Domain\Order\Models\OrderStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class OrderController
{
    public function index(): View
    {
        Gate::authorize('viewAny', Order::class);

        if (auth()->user()->hasRole(['administrator'])) {
            $orders = Order::orderBy('id')->paginate(12);
        } else {
            $orders = auth()->user()->assignments()->paginate(12);
        }

        return view('pages.order.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        Gate::authorize('view', $order);

        return view('pages.order.show', compact('order'));
    }

    public function edit(Order $order): View
    {
        Gate::authorize('update', $order);

        $statuses = OrderStatus::all();

        return view('pages.order.update', compact('order', 'statuses'));
    }

    public function update(OrderStatusData $data): RedirectResponse
    {
        Gate::authorize('update', $data->order);

        return redirect()->route('orders.show', UpdateOrderStatusAction::execute($data))
            ->with('success', 'Заказ успешно обновлен.');
    }
}
