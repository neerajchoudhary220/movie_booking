@props(['active' => false])

@php
$classes = $active
? 'flex items-center px-3 py-2 rounded-lg text-sm font-medium bg-gray-900 text-white'
: 'flex items-center px-3 py-2 rounded-lg text-sm text-gray-700 hover:bg-gray-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>