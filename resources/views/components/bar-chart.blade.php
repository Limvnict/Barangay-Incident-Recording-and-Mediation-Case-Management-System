@props(['title', 'data'])
@php $max = max(array_merge([1], array_values($data))); @endphp

<div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
    <h3 class="font-semibold mb-3">{{ $title }}</h3>

    @forelse ($data as $label => $count)
        <div class="mb-2">
            <div class="flex justify-between text-sm"><span>{{ $label }}</span><span>{{ $count }}</span></div>
            <div class="bg-gray-100 rounded h-3">
                <div class="bg-blue-600 h-3 rounded" style="width: {{ $count / $max * 100 }}%"></div>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">No data yet.</p>
    @endforelse
</div>
