<div class="w-100 d-flex justify-content-between align-items-center">
    <div class="toggle-navigation">
        @include('components.icons.app-icon', ['name' => 'burger-menu', 'type' => 'responsive'])
    </div>
    <div class="account d-flex gap-3 py-1 px-2">
        <div class="account__data d-flex align-items-center gap-3">
            <div class="account__avatar d-flex justify-content-center align-items-center rounded-circle">
                KS
            </div>
            @auth
                <div class="account__data">
                    <div class="account__name fw-bold">{{auth()->user()->name}} {{auth()->user()->surname}}</div>
                    <div class="account__post opacity-50 mt-1">{{auth()->user()->getRoleNames()->first()}}</div>
                </div>
            @endauth
        </div>
        <div class="dropdown d-flex justify-content-center align-items-center">
            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @include('components.icons.app-icon', ['name' => 'arrow-down', 'type' => 'responsive'])
            </button>

            <form action="{{route('logout')}}" method="POST"> @csrf
                <ul class="dropdown-menu">

                    <li>
                        <button class="dropdown-item">Выход</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/js/burger/burger.js') }}" defer></script>
