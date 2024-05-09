@extends('layouts.app')
@section('title')
    Заказы
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>Заказы</x-typography.card-title>
        <table id="estates-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Адрес</th>
                <th>Статус</th>
                <th>Продукты</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <th>{!! "{$order->address->name} {$order->address->surname}, {$order->address->company_name},<br>
                        {$order->address->country}, {$order->address->state}, {$order->address->city}, <br>{$order->address->street}, {$order->address->house_number}, {$order->address->zip_code},
                        <br>{$order->address->phone}, {$order->address->email}, {$order->address->telegram_username}" !!}</th>
                    <th>{{ $order->status->name }}</th>
                    <th>{!!  $order->products->implode('name', ', <br>') !!}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
