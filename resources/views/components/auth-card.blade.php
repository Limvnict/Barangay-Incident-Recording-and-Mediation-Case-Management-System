@props(['heading'])
<div class="max-w-md mx-auto bg-white border border-gray-200 rounded-lg shadow-sm p-6 mt-8">
    <h1 class="text-2xl font-bold mb-6 text-center">{{ $heading }}</h1>

    {{ $slot }}
</div>
