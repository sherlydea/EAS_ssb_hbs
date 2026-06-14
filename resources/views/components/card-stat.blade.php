@props([
    'title',
    'value',
    'icon',
    'type' => 'info'
])

@php
    // hanya untuk icon background (TIDAK ubah UI layout)
    $bg = match($type) {
        'success' => 'bg-green-100 text-green-600',
        'warning' => 'bg-yellow-100 text-yellow-600',
        'danger'  => 'bg-red-100 text-red-600',
        default   => 'bg-[#fff0e6] text-[#7a1025]',
    };
@endphp

<div class="bg-white border border-[#e8d9c0] rounded-xl p-4 flex items-center gap-4 shadow-sm">

    <div class="w-10 h-10 flex items-center justify-center rounded-lg {{ $bg }}">
        <span class="text-lg">{{ $icon }}</span>
    </div>

    <div>
        <p class="text-xs text-gray-500">{{ $title }}</p>
        <h2 class="text-lg font-bold">{{ $value }}</h2>
    </div>

</div>