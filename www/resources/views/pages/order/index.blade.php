@extends('layouts.app')
@section('title')
    Все заказы | Lytko
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>Все заказы</x-typography.card-title>
        <x-cards.success-alert/>
        <div class="table-responsive">
            <table id="estates-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>WordPress ID</th>
                    <th>Товары</th>
                    <th>Заказчик</th>
                    <th>Ответственный сотрудник</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>

                @forelse ($orders as $order)
                    <tr>
                        <th><a href="orders/{{$order->id}}">{{ $order->id }}</a></th>
                        <th><a href="{{$order->getWordpressUrl()}}">{{ $order->wordpress_id }}</a></th>
                        <th>{!! $order->products->implode('name', ', <br>') !!}</th>
                        <th>{{ $order->user?->getFullName()}}</th>
                        @if($order->employee)
                            <th>{{ $order->employee?->getFullName() }}</th>
                        @else
                            <th><span class="badge text-bg-danger mx-auto">Сотрудник не назначен</span></th>
                        @endif

                        <th><span class="badge text-bg-warning mx-auto">{{ $order->status->name }}</span></th>
                    </tr>
                @empty
                    <tr><th>Заказов не назначено</th></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if(!$orders->isEmpty())
            {{ $orders->links() }}
        @endif
    </x-cards.table>
@endsection

