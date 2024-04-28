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
                <th>Заказчик</th>
                <th>Статус</th>
                <th>Статус</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th>{{ $order->id }}</th>
                    <th>{{ $order->name }}</th>
                    <th>{{ $order->country }}</th>
                    <th>{{ $order->city }}</th>
                    <th>{{ $order->email }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
