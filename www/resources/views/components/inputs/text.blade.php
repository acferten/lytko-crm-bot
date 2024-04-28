@props(['id', 'name', 'label', 'name', 'message', 'type' => 'text'])

<div class="{{ $attributes->get('class') }}">
    <label for="{{ $id }}" class="form-label @error($name) is-invalid @enderror">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}"
           aria-describedby="emailHelp" {{ $attributes->class(['form-control'])->merge(['placeholder' => '']) }}>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
