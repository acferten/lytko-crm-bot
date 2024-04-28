<div class="{{ $attributes->get('class') }}">
    <label for="{{ $id }}" class="form-label @error($name) is-invalid @enderror">{{ $label }}</label>
    <input type="password" id="{{ $id }}" name="{{ $name }}"
           aria-describedby="passwordHelp" {{ $attributes->class(['form-control'])->merge(['placeholder' => '']) }}>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
