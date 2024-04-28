@extends('layouts.auth')
@section('content')
    <x-cards.card>
        <x-typography.card-title>Recover password</x-typography.card-title>
        <p>Code has been sending on your E-mail</p>
        <form action="#">
            <x-inputs.text id="login" name="username" label="E-mail" class="mb-3"/>
            <x-buttons.button type="submit" text="SEND"/>
        </form>
    </x-cards.card>
@endsection
