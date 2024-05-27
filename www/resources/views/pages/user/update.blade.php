@extends('layouts.app')
@section('title')
    Сотрудник #{{ $user->id }} | Lytko
@endsection
@section('content')
    <x-cards.table>
        <div class="d-flex justify-content-between flex-wrap gap-5">
            <div>
                <x-typography.card-title>Обновление сотрудника #{{ $user->id }}</x-typography.card-title>
                <p style="white-space: pre-line;"> {!! \Domain\User\Telegram\Messages\EmployeeCardMessage::getCard($user) !!}</p>
                <div class="row mb-3">
                    <form action="{{route('users.update-data', $user)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-inputs.select id="role" name="role_id" label="Выберите новую роль"
                                         :options="$roles" :display_name="'name'" class="mb-3 multi-select-wrapper"/>
                        <button class="btn btn-secondary">Изменить роль</button>
                    </form>
                </div>
                <div class="row">
                    <form action="{{route('users.update-data', $user)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-inputs.text id="telegram_id" name="telegram_id" label="Telegram ID"
                                       class="mb-3 multi-select-wrapper" value="{{$user->telegram_id}}"/>
                        <x-inputs.text id="telegram_username" name="telegram_username" label="Telegram username"
                                       class="mb-3 multi-select-wrapper" value="{{$user->telegram_username}}"/>
                        <button class="btn btn-secondary">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </x-cards.table>
@endsection
