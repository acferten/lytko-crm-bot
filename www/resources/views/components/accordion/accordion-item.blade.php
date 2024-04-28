@props(['title' => '', 'iconName' => '', 'isActive' => false, 'link' => '/'])

<a href="{{ $link }}" class="accordion__link text-decoration-none">
<div class="w-100 ps-2">
    <div {{ $attributes->class(['user-select-none', 'd-flex', 'align-items-center', 'justify-content-between', 'accordion__item--active' => $isActive]) }}>
        <div class="accordion__main-text d-flex gap-3">
            <span class="accordion__icon">
                @include('components.icons.app-icon', ['name' => $iconName])
            </span>
            <span class="accordion__button-text">
                {{ $title }}
            </span>
        </div>
    </div>
</div>
</a>
