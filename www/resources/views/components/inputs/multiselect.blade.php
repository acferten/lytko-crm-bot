@props(['id', 'name', 'label', 'name', 'message', 'type' => 'text', 'options' => [], 'display_name'])


<div class="{{ $attributes->get('class') }}">
    <label for="{{ $id }}" class="form-label @error($name) is-invalid @enderror">{{ $label }}</label>
    <select id="{{ $id }}" {{ $attributes->class(['form-select form-multiselect'])->merge(['data-placeholder' => '']) }} name="{{ $name }}[]" multiple>
        @foreach($options as $option)
            <option value="{{$option->id}}">{{ $option->$display_name }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
    <script src="{{asset('js/select/multiselect.js')}}" defer></script>
@endpush
