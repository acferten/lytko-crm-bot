@extends('layouts.auth')
@section('content')
    <x-cards.card>
        <x-typography.card-title>Log In</x-typography.card-title>
        <p class="d-flex justify-content-between">
        </p>
        <form action="/login" method="post">
            @csrf
            <x-inputs.text id="login" name="email" label="E-mail" class="mb-3"/>
            <x-inputs.password id="password" name="password" label="Password" class="mb-3"/>
            <div class="d-flex justify-content-between">
{{--                <a class="link" href="{{ route('recover-password') }}">forgot your password?</a>--}}
            </div>
            <x-buttons.button type="submit" text="LOG IN"/>
        </form>
    </x-cards.card>
@endsection
