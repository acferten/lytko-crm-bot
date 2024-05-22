<nav class="nav-bar overflow-hidden">
    <div class="w-100 d-flex flex-column gap-2">
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <a style="width: 50px" href="{{ route('orders.index') }}">@include('components.icons.app-icon', ['name' => 'logo', 'type' => 'responsive'])</a>
            <p class="fw-bold">Lytko CRM</p>
        </div>
        <x-accordion.accordion-list isActive="{{ request()->routeIs('orders.*')}}" title="Заказы"
                                    iconName="orders">
            <x-accordion.accordion-item isActive="{{ request()->routeIs('orders.index') }}" title="Все заказы"
                                        iconName="orders"
                                        link="{{ route('orders.index') }}"></x-accordion.accordion-item>
        </x-accordion.accordion-list>
    </div>
</nav>
