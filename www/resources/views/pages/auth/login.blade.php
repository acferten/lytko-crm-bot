@extends('layouts.auth')
@section('content')
    <x-cards.card>
        <x-typography.card-title>Log In</x-typography.card-title>
        <p class="d-flex justify-content-between">
            <span>Not a account?</span>
            <a class="link" href="{{ route('signup') }}">Registration</a>
        </p>
        <form action="/login" method="post">
            @csrf
            <x-inputs.text id="login" name="email" label="E-mail" class="mb-3"/>
            <x-inputs.password id="password" name="password" label="Password" class="mb-3"/>
            <div class="d-flex justify-content-between">
                <x-inputs.checkbox id="remember-me" name="remember-me" label="Remember me" class="mb-3"/>
                <a class="link" href="{{ route('recover-password') }}">forgot your password?</a>
            </div>
            <x-buttons.button type="submit" text="LOG IN"/>
        </form>
    </x-cards.card>
@endsection
