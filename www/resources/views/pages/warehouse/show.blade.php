@extends('layouts.app')
@section('title')
    {{ $warehouse->name }}
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex justify-content-between gap-5">
            <div>
                <x-typography.card-title>{{ $warehouse->name }}</x-typography.card-title>
                <p>Vendor - {{ $warehouse->vendor->name }}</p>
                <p>Address - {{ $warehouse->country }}, {{ $warehouse->city }}</p>
                <p>Type - {{ $warehouse->type->name }}</p>
            </div>
            <div class="warehouse-image" style="background-image: url('{{ $warehouse->getWarehousePhoto() }}')">
            </div>
        </div>
        <div>
            <x-typography.sub-title>Products in stock:</x-typography.sub-title>
            <table id="products-table" class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>HS code</th>
                    <th>Amount in stock</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($warehouse->products->unique() as $product)
                    <tr>
                        <th>{{ $product->id }}</th>
                        <th>{{ $product->model }}</th>
                        <th>{{ $product->price }}</th>
                        <th>{{ $product->hs_code }}</th>
                        <th>
                            {{ $warehouse->products()->where('product_id', $product->id)->count() }}
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/warehouse.js')}}" defer></script>
@endpush
