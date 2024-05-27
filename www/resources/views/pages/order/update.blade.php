@extends('layouts.app')
@section('title')
    Обновление заказа #{{ $order->wordpress_id }} | Lytko
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex justify-content-between flex-wrap gap-5">
            <div>
                <x-typography.card-title>Обновление заказа #{{ $order->id }}</x-typography.card-title>
                <p style="white-space: pre-line;"> {!! \Domain\Order\Telegram\Messages\OrderCardMessage::getCard($order) !!}</p>
                <div class="row">
                    <form action="{{route('orders.update', $order)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-inputs.select id="status" name="status_id" label="Выберите новый статус"
                                         :options="$statuses" :display_name="'name'" class="mb-3 multi-select-wrapper"/>
                        <button class="btn btn-secondary">Обновить статус</button>
                    </form>
                </div>

            </div>

            <div class="product-image"
                 style="background-image: url('{{ $order->products()->first()->photos()->first()->file }}');">
            </div>

        </div>
    </x-cards.table>
@endsection
