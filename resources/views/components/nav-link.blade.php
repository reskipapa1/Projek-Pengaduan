@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-2 py-2 text-xl rounded-lg text-emerald-600 font-semibold transition'
            : 'inline-flex items-center px-2 py-4 text-xl rounded-lg text-gray-600 hover:bg-gray-100 transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
