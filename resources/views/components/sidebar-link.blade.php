@props(['active' => false, 'icon' => null])

@php
$classes = $active
    ? 'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium bg-white/10 text-white border-l-2 border-teal -ml-px pl-[10px]'
    : 'flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium text-white/70 hover:text-white hover:bg-white/5 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            {{ $icon }}
        </svg>
    @endif
    <span>{{ $slot }}</span>
</a>
