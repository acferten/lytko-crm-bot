@props(['id', 'name', 'label', 'name', 'message', 'type' => 'text', 'options' => []])


<div class="{{ $attributes->get('class') }}">
    <label for="{{ $id }}" class="form-label @error($name) is-invalid @enderror">{{ $label }}</label>
    <select id="{{ $id }}"
            {{ $attributes->class(['form-select'])->merge(['placeholder' => '']) }} name="{{ $name }}"
    >
        @foreach($options as $option)
            <option value="{{$option->id}}">{{ $option->name }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
