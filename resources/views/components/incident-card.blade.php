@props(['incident', 'href'])

<div class="bg-white border border-gray-200 rounded-lg p-4 mb-3 shadow-sm">
    <div class="flex items-center justify-between">
        <h3 class="font-semibold text-lg">{{ $incident->blotter_no }} · {{ $incident->incident_type }}</h3>
        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $incident->status }}</span>
    </div>
    <p class="text-gray-600 mt-1">{{ \Illuminate\Support\Str::limit($incident->narrative, 100) }}</p>
    <p class="text-xs text-gray-500 mt-2">
        {{ $incident->complainant_name }} vs. {{ $incident->respondent_name }}
        · {{ $incident->incident_date->format('M d, Y') }}
    </p>

    <a href="{{ $href }}" class="inline-block mt-3 text-sm text-blue-600 hover:underline">View case</a>
</div>
