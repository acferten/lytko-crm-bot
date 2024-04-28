@extends('layouts.auth')
@section('content')
    <x-cards.card>
        <x-typography.card-title>Registration</x-typography.card-title>
        <p class="d-flex justify-content-between"><span>Already have an account?</span><a class="link" href="{{ route('login') }}">Log in</a></p>
        <form action="#">
            <x-inputs.text id="firstName" name="firstName" label="First name" class="mb-3" />
            <x-inputs.text id="surname" name="surname" label="Surname" class="mb-3" />
            <x-inputs.text id="patronymic" name="patronymic" label="Patronymic (optional)" class="mb-3" />
            <x-inputs.text id="email" name="email" label="E-mail" class="mb-3" />
            <x-inputs.password id="password" name="password" label="Password" class="mb-3" />
            <x-inputs.password id="repeat-password" name="repeat-password" label="Repeat password" class="mb-3" />
            <x-buttons.button type="submit" text="REGISTER" />
        </form>
    </x-cards.card>
@endsection
