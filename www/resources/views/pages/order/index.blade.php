@extends('layouts.app')
@section('title')
    Orders
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>All orders</x-typography.card-title>
        <table id="estates-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>reference</th>
                <th>SKU</th>
                <th>status</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <th><a href="orders/{{$order->id}}">{{ $order->id }}</a></th>
                    <th>{{ $order->reference }}</th>
                    <th>{{ $order->SKU }}</th>
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
