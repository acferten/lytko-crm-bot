@extends('layouts.app')
@section('title')
    Заказ #{{ $order->wordpress_id }} | Lytko
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex justify-content-between flex-wrap gap-5">
            <div>
                <x-typography.card-title>Заказ</x-typography.card-title>
                <p style="white-space: pre-line;"> {!! \Domain\Order\Telegram\Messages\OrderCardMessage::getCard($order) !!}</p>
                <div class="row">
                    <a class="btn btn-secondary" href="{{route('orders.edit', $order)}}">Обновить статус</a>
                </div>

            </div>

            <div class="product-image"
                 style="background-image: url('{{ $order->products()->first()->photos()->first()->file }}');">
            </div>

        </div>
        <div>
            <x-typography.sub-title>Заказанные товары:</x-typography.sub-title>
            <table id="products-table" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>WordPress ID</th>
                    <th>Товар</th>
                    <th>Опции</th>
                    <th>Количество</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <th>{{ $product->wordpress_id }}</th>
                        <th>{{ $product->name }}</th>
                        <th>{{ $product->pivot->options->implode('name', ', ') }}</th>
                        <th>{{ $product->pivot->quantity }}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-cards.table>
@endsection
