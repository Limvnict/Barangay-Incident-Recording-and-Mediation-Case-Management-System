@props(['type' => 'success'])

@php
    $styles = [
        'success' => 'bg-green-100 text-green-800 border-green-200',
        'error'   => 'bg-red-100 text-red-800 border-red-200',
    ][$type];
@endphp

<div {{ $attributes->merge(['class' => "border rounded-lg px-4 py-3 mb-4 $styles"]) }}>
    {{ $slot }}
</div>
