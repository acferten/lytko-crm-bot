@props(['title' => '', 'iconName' => '', 'isActive' => false])

<div class="accordion">
    <div {{ $attributes->class(['accordion__button', 'user-select-none', 'd-flex', 'align-items-center', 'justify-content-between', 'fw-bold', 'accordion__button--open' => $isActive])  }}>
        <div class="accordion__main-text d-flex gap-3">
            <span class="accordion__icon">
                @include('components.icons.app-icon', ['name' => $iconName])
            </span>
            <span class="accordion__button-text">
                {{ $title }}
            </span>
        </div>
        <span {{ $attributes->class(['accordion__arrow', 'accordion__arrow--open' => $isActive])  }}>
        @include('components.icons.app-icon', ['name' => 'arrow-right', 'type' => 'responsive'])
        </span>
    </div>
    <div class="accordion__content d-flex flex-column gap-2 mt-2" style="max-height: 0">
        {{ $slot }}
    </div>
</div>

@once
    <script src="{{ asset('js/accordion/accordion.js') }}" defer></script>
@endonce
