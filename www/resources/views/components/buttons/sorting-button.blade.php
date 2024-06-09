@props(['route_name', 'parameter_name', 'desc' => true,])

<a href="{{route($route_name, ['sort' => $parameter_name . ',' . ($desc ? 'desc' : 'asc'),])}}"
   style="text-decoration: none;">
    @if ($desc)
        <img src="/icons/sorting-desc.svg" width="20px" alt="desc-sorting-icon">
    @else
        <img src="/icons/sorting-asc.svg" width="20px" alt="desc-sorting-icon">
    @endif
</a>
