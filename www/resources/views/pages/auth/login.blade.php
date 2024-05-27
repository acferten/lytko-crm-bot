@extends('layouts.auth')
@section('content')
    <x-cards.card>
        <x-typography.card-title>Вход в систему</x-typography.card-title>
        <form action="/login" method="post">
            @csrf
            <x-inputs.text id="login" name="credential" label="Имя пользователя или email" class="mb-3"/>
            <x-inputs.password id="password" name="password" label="Пароль" class="mb-3"/>
            <a class="link" href="{{ route('recover-password') }}">Забыли пароль?</a>
            <x-buttons.button type="submit" class="mt-4" text="Войти"/>
        </form>
    </x-cards.card>
@endsection
