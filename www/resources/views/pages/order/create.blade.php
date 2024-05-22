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
        <x-typography.card-title>Create new order</x-typography.card-title>
        <form action="{{ route('orders.store') }}" method="post">
            @csrf
            <x-inputs.text id="reference" name="reference" label="Order reference" class="mb-3"/>
            <x-inputs.multiselect id="devices" name="devices[]" label="Devices"
                                  :options="$devices" :display_name="'model'" class="mb-3 multi-select-wrapper"/>
            <x-inputs.multiselect id="serials" name="serials[]" label="Serials"
                                  :options="$serials" :display_name="'serial_number'"
                                  class="mb-3 multi-select-wrapper" />
            <x-buttons.button type="button" size="small" onclick="addFn()" class="mb-3" :background="'secondary'">Add another product</x-buttons.button>
            <div id="inputFields"></div>
            <x-buttons.button type="submit" text="CREATE"/>
        </form>
    </x-cards.form>

    <script>
        function addFn() {
            const divEle = document.getElementById("inputFields");
            divEle.innerHTML += `
        <div>
          <input type="text" placeholder="Enter value" class="input-field">
          <input type="text" placeholder="Enter value" class="input-field">
        </div>
      `;
        }
    </script>
@endsection
