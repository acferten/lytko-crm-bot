@extends('layouts.app')
@section('title')
    Все заказы | Lytko
@endsection
@section('content')
    <x-cards.table>
        <x-typography.card-title>Все заказы</x-typography.card-title>
        <x-cards.success-alert/>
        <div class="table-responsive">
            <div class="col-4">
                <form method="get" action="{{route('orders.index')}}" class="mb-4">
                    <div class="d-flex">
                        <input type="text" name="search" class="form-control" id="search" placeholder="Поиск"
                               value="{{request('search')}}">
                        <input type="submit" class="btn btn-secondary" id="search"
                               value="Найти" placeholder="Поиск">
                    </div>
                </form>
            </div>
            <table id="estates-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>
                        <span>ID</span>
                        <div style="width:45px">
                            <x-buttons.sorting-button :route_name="'orders.index'"
                                                      :parameter_name="'id'"></x-buttons.sorting-button>
                            <x-buttons.sorting-button :route_name="'orders.index'" :parameter_name="'id'"
                                                      :desc="false"></x-buttons.sorting-button>
                        </div>
                    </th>
                    <th>
                        <span>WordPress ID</span>
                        <div>
                            <x-buttons.sorting-button :route_name="'orders.index'"
                                                      :parameter_name="'wordpress_id'"></x-buttons.sorting-button>
                            <x-buttons.sorting-button :route_name="'orders.index'" :parameter_name="'wordpress_id'"
                                                      :desc="false"></x-buttons.sorting-button>
                        </div>
                    </th>
                    <th>Товары</th>
                    <th>Заказчик</th>
                    <th>Ответственный сотрудник</th>
                    <th><span>Статус</span>
                        <div>
                            <x-buttons.sorting-button :route_name="'orders.index'"
                                                      :parameter_name="'status_id'"></x-buttons.sorting-button>
                            <x-buttons.sorting-button :route_name="'orders.index'" :parameter_name="'status_id'"
                                                      :desc="false"></x-buttons.sorting-button>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>

                @forelse ($orders as $order)
                    <tr>
                        <th><a href="orders/{{$order->id}}">{{ $order->id }}</a></th>
                        <th><a href="{{$order->getWordpressUrl()}}">{{ $order->wordpress_id }}</a></th>
                        <th>{!! $order->products->implode('name', ', <br>') !!}</th>
                        <th>{{ $order->user?->getFullName()}}</th>
                        @if($order->employee)
                            <th>{{ $order->employee?->getFullName() }}</th>
                        @else
                            <th><span class="badge text-bg-danger mx-auto">Сотрудник не назначен</span></th>
                        @endif
                        <th><span class="badge text-bg-warning mx-auto">{{ $order->status->name }}</span></th>
                    </tr>
                @empty
                    <tr>
                        <th>Заказов не назначено</th>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if(!$orders->isEmpty())
            {{ $orders->appends(request()->input())->links() }}
        @endif
    </x-cards.table>
@endsection

