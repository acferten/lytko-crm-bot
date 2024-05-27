@if (!empty(session('success')))
    <div class="col-12">
        <div class="alert alert-success" role="alert" style=" text-transform: none;">
            {{ session('success') }}
        </div>
    </div>
@endif
