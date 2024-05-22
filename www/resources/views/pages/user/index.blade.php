@extends('layouts.app')
@section('title')
    Users
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex gap-4 align-items-start">
            <x-typography.card-title>All Users</x-typography.card-title>
            <x-buttons.link size="small" href="/users/create">add new</x-buttons.link>
        </div>
        <table id="estates-table" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>surname</th>
                <th>phone</th>
                <th>phone 2</th>
                <th>email</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <th>{{ $user->name }}</th>
                    <th>{{ $user->surname }}</th>
                    <th>{{ $user->phone }}</th>
                    <th>{{ $user->phone_2 }}</th>
                    <th>{{ $user->email }}</th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
