@extends('layouts.app')
@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <script src="{{ asset('js/user/create.js') }}" defer></script>
@endpush
@section('title')
    create user
@endsection
@section('content')
    <x-cards.form>
        <x-typography.card-title>Create user</x-typography.card-title>
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            <x-inputs.text id="firstName" name="name" label="First name" class="mb-3"/>
            <x-inputs.text id="surname" name="surname" label="Surname" class="mb-3"/>
            <x-inputs.text id="email" name="email" label="E-mail" class="mb-3"/>
            <x-inputs.text id="phone" name="phone" label="Phone" class="mb-3"/>
            <x-inputs.text id="phone_2" name="phone_2" label="Phone 2" class="mb-3"/>
            <x-inputs.select id="role" name="role_id" label="Role" :options="$roles" class="mb-3"/>
            <x-inputs.multiselect id="warehouses" name="warehouse_ids[]" label="Available warehouses"
                                  :options="$warehouses" :display_name="'name'" class="mb-3 multi-select-wrapper"/>
            <x-inputs.password id="password" name="password" label="Password" class="mb-3"/>
            <x-inputs.password id="repeat-password" name="password_confirmation" label="Repeat password" class="mb-3"/>
            <x-buttons.button type="submit" text="REGISTER"/>
        </form>
    </x-cards.form>
@endsection
