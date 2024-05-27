@extends('layouts.app')
@section('title')
    Сотрудники | Lytko
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex gap-4 align-items-start">
            <x-typography.card-title>Список сотрудников</x-typography.card-title>
        </div>
        <x-cards.success-alert />
        <table id="estates-table" class="table table-hover table-bordered table-striped table-responsive">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>email</th>
                <th>Telegram</th>
                <th>Роль</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <th>{{ $user->getFullName() }}</th>
                    <th>{{ $user->email }}</th>
                    <th>{{ $user->telegram_username }}</th>
                    <th>{{ $user->getRoleNames()->first() }}</th>
                    <th><a href="{{route('users.edit', $user)}}" class="btn btn-secondary">Изменить роль</a></th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-cards.table>
@endsection

@push('scripts')
    <script src="{{asset('js/table/table.js')}}" defer></script>
@endpush
