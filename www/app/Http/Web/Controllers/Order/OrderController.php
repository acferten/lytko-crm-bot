<?php

namespace App\Http\Web\Controllers\Order;

use Domain\Order\Models\Order;
use Illuminate\Http\Request;

class OrderController
{
    public function index()
    {
        $orders = Order::all();

        return view('pages.order.index', compact('orders'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Order $order)
    {
        return view('pages.order.show', compact('order'));
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
