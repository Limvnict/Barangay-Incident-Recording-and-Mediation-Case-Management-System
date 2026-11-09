<div class="bg-white p-5 rounded shadow-sm mb-5">
    <h1 class="text-xl font-semibold">{{ $incident->blotter_no }} <span class="text-sm font-normal text-slate-500">·
            {{ $incident->status }}</span></h1>
    <div class="text-sm text-slate-500">{{ $incident->incident_type }} ·
        {{ $incident->incident_date->format('M d, Y') }} · {{ $incident->location }}</div>
    <div class="grid md:grid-cols-2 gap-2 mt-3 text-sm">
        <div><b>Complainant:</b> {{ $incident->complainant_name }}</div>
        <div><b>Respondent:</b> {{ $incident->respondent_name }}</div>
    </div>
    <p class="mt-3 text-sm whitespace-pre-line">{{ $incident->narrative }}</p>
</div>
<h2 class="font-semibold mb-2">Mediation Hearings</h2>
<div class="bg-white rounded shadow-sm mb-4">@forelse($incident->hearings as $h)
    <div class="p-3 border-b text-sm"><b>{{ $h->stage }}</b> · {{ $h->hearing_date->format('M d, Y g:i A') }} · <span
            class="font-medium">{{ $h->outcome }}</span>
        @if($h->notes)
        <div class="text-slate-600 mt-1">{{ $h->notes }}</div>@endif
    </div>
@empty<div class="p-4 text-slate-500 text-sm">No hearings scheduled yet.</div>@endforelse
</div>