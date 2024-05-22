<nav class="nav-bar overflow-hidden">
    <div class="w-100 d-flex flex-column gap-2">
        <div class="d-flex justify-content-between mb-4">
            <a href="{{ route('orders.index') }}">@include('components.icons.app-icon', ['name' => 'logo', 'type' => 'responsive'])</a>
            <p class="fw-light">Release 3.0.0</p>
        </div>
        <x-accordion.accordion-list isActive="{{ request()->routeIs('orders.*')}}" title="Warehouses"
                                    iconName="order">
            <x-accordion.accordion-item isActive="{{ request()->routeIs('orders.index') }}" title="All warehouses"
                                        iconName="order"
                                        link="{{ route('orders.index') }}"></x-accordion.accordion-item>
        </x-accordion.accordion-list>
    </div>
</nav>
