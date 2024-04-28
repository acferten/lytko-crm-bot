<nav class="nav-bar overflow-hidden">
    <div class="w-100 d-flex flex-column gap-2">
        <x-accordion.accordion-item isActive="{{ request()->is('/') }}" title="Главная"
                                    iconName="home"></x-accordion.accordion-item>
        {{--        <x-accordion.accordion-list title="Orders" iconName="warehouse">--}}
        {{--            <x-accordion.accordion-item title="Create order" iconName="warehouse"></x-accordion.accordion-item>--}}
        {{--            <x-accordion.accordion-item title="My orders" iconName="warehouse"></x-accordion.accordion-item>--}}
        {{--        </x-accordion.accordion-list>--}}
        <x-accordion.accordion-list isActive="{{ request()->is('orders')}}" title="Заказы"
                                    iconName="order">
            <x-accordion.accordion-item isActive="{{ request()->is('orders') }}" title="Все заказы"
                                        iconName="order" link="{{ route('orders.index') }}" link="{{ route('orders.index') }}"></x-accordion.accordion-item>
        </x-accordion.accordion-list>
    </div>
</nav>
