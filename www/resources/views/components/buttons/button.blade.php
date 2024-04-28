@props(['color' => 'white', 'background' => 'accent', 'text' => ''])

<button
    style="background-color: {{'var(--' . $background . ')'}}"
    {{ $attributes->class(['btn', 'text-center', 'w-100', 'fw-bold', 'text-'.$color])->merge(['type' => 'button']) }}
    @disabled($errors->isNotEmpty())>{{ $text }}</button>
