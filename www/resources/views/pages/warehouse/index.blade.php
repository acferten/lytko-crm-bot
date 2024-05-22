@extends('layouts.app')
@section('title')
    Warehouses
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>All warehouses</x-typography.card-title>
        <table id="estates-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>country</th>
                <th>city</th>
                <th>email</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($warehouses as $warehouse)
                <tr>
                    <th><a href="warehouses/{{ $warehouse->id }}">{{ $warehouse->id }}</a></th>
                    <th>{{ $warehouse->name }}</th>
                    <th>{{ $warehouse->country }}</th>
                    <th>{{ $warehouse->city }}</th>
                    <th>{{ $warehouse->email }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
