@extends('layouts.app')
@section('title')
    Все заказы | Lytko
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>Все заказы</x-typography.card-title>
        <x-cards.success-alert/>
        <table id="estates-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>WordPress ID</th>
                <th>Товары</th>
                <th>Заказчик</th>
                <th>Ответственный сотрудник</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th><a href="orders/{{$order->id}}">{{ $order->wordpress_id }}</a></th>
                    <th>{!! $order->products->implode('name', ', <br>') !!}</th>
                    <th>{{ $order->user?->getFullName()}}</th>
                    @if($order->employee)
                        <th>{{ $order->employee?->getFullName() }}</th>
                    @else
                        <th><span class="badge text-bg-danger mx-auto">Сотрудник не назначен</span></th>
                    @endif

                    <th><span class="badge text-bg-warning mx-auto">{{ $order->status->name }}</span></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
