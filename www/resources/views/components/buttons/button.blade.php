@props(['color' => 'white', 'background' => 'accent', 'text' => '', 'size' => 'responsive'])

<button
    style="background-color: {{'var(--' . $background . ')'}}"
    {{ $attributes->class(['btn', 'text-center', 'btn--size-' . $size, 'fw-bold', 'text-'.$color])->merge(['type' => 'button']) }}>{{ $text }}{{ $slot }}</button>
