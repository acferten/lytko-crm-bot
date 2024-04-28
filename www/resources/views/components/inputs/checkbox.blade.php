<div class="{{ $attributes->get('class') }} form-check">
    <input type="checkbox" class="form-check-input" id="{{ $id }}" name="{{ $name }}" aria-describedby="emailHelp">
    <label for="{{ $id }}" class="form-label @error($name) is-invalid @enderror">{{ $label }}</label>
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
