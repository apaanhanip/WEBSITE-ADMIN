@props(['status', 'id' => null])

@php
    $color = match($status) {
        'pending' => 'yellow',
        'diproses' => 'blue',
        'selesai' => 'green',
        'dibatalkan' => 'red',
        default => 'gray',
    };
    $label = match($status) {
        'pending' => 'Pending',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
        default => ucfirst($status),
    };
@endphp

<span @if($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => "badge badge-{$color}"]) }}>{{ $label }}</span>
