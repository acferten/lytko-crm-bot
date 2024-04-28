@props(['type' => 'regular', 'name', 'around' => false])

<div class="app-icon app-icon--{{ $type }}">
    <img src="{{ asset('icons/' . $name . '.png') }}" alt="{{ $name }}" {{$attributes->class(['app-icon-image', 'app-icon--around' => $around])}}>
</div>
