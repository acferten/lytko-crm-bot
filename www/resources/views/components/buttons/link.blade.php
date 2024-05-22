@props(['color' => 'white', 'background' => 'accent', 'size' => 'responsive', 'href' => '#'])

<a
    style="background-color: {{'var(--' . $background . ')'}}"
    {{ $attributes->class(['btn', 'text-center', 'btn--size-' . $size, 'fw-bold', 'text-'.$color])->merge(['role' => 'button', 'href' => $href]) }}>{{ $slot }}</a>
