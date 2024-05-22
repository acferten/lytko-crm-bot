@extends('layouts.app')
@section('title')
    Order № {{ $order->id }}
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>Order № {{ $order->id }}</x-typography.card-title>
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">name</th>
                <th scope="col">value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">reference</th>
                <td>{{ $order->reference }}</td>
            </tr>
            <tr>
                <th scope="row">status</th>
                <td>{{ $order->type->name }}</td>
            </tr>
            <tr>
                <th scope="row">sender</th>
                <td>{{ $order->sender->name }}</td>
            </tr>
            <tr>
                <th scope="row">sent to</th>
                <td>{{ $order->recipient->name }}, {{ $order->recipient->city }}, {{ $order->recipient->country }}</td>
            </tr>
            <tr>
                <th scope="row">SKU</th>
                <td>{{ $order->SKU }}</td>
            </tr>
            <tr>
                <th scope="row">AWB</th>
                <td>{{ $order->AWB }}</td>
            </tr>
            <tr>
                <th scope="row">invoice</th>
                <td><a href="{{ $order->getInvoiceFile() }}">{{ $order->invoice }}</a></td>
            </tr>
            <tr>
                <th scope="row">POD</th>
                <td><a href="{{ $order->getPODFile() }}">{{ $order->POD }}</a></td>
            </tr>
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/order.js')}}" defer></script>
@endpush
