
@extends('layout')

@section('content')

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('official.dashboard') }}"
               class="text-sm text-emerald-700 hover:underline">
                &larr; Back to Dashboard
            </a>

            <h1 class="text-2xl font-bold text-slate-800 mt-2">
                Case Details
            </h1>

            <p class="text-sm text-slate-500">
                Manage incident records and mediation activities
            </p>
        </div>

        <a href="{{ route('official.cases.edit', $incident) }}"
           class="bg-emerald-700 text-white px-4 py-2 rounded-lg hover:bg-emerald-800 text-sm">
            Edit Complaint
        </a>
    </div>
    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <h2 class="font-semibold text-slate-800 mb-3">Case Documents and Actions</h2>

        <div class="flex flex-wrap gap-3 text-sm">

            <a href="{{ route('official.cases.print', [$incident, 'summons']) }}"
               target="_blank"
               class="border border-emerald-600 text-emerald-700 px-4 py-2 rounded-lg hover:bg-emerald-50">
                Print Summons
            </a>

            <a href="{{ route('official.cases.print', [$incident, 'notice']) }}"
               target="_blank"
               class="border border-emerald-600 text-emerald-700 px-4 py-2 rounded-lg hover:bg-emerald-50">
                Print Hearing Notice
            </a>

            <a href="{{ route('official.cases.print', [$incident, 'settlement']) }}"
               target="_blank"
               class="border border-emerald-600 text-emerald-700 px-4 py-2 rounded-lg hover:bg-emerald-50">
                Print Settlement
            </a>

            <form action="{{ route('official.cases.destroy', $incident) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this whole case?')"
                  class="ml-auto">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="border border-red-200 text-red-600 px-4 py-2 rounded-lg hover:bg-red-50">
                    Delete Case
                </button>
            </form>

        </div>
    </div>
    @if ($others > 0)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl p-4">
            <p class="font-semibold">Previous Case Record</p>
            <p class="text-sm mt-1">
                {{ $incident->respondent_name }} was also listed as a respondent
                in {{ $others }} other case(s).
            </p>
        </div>
    @endif
    <x-case-detail :incident="$incident" :editable="true" />
    <div class="bg-white border rounded-xl p-5 shadow-sm">

        <h2 class="text-lg font-semibold text-slate-800">
            Update Case Status
        </h2>

        <p class="text-sm text-slate-500 mb-4">
            Change the current progress of this incident.
        </p>

        <form action="{{ route('official.cases.status', $incident) }}"
              method="POST">

            @csrf
            @method('PATCH')

            <x-input-field
                label="Case Status"
                name="status"
                type="select"
                :options="\App\Models\Incident::STATUSES"
                :value="$incident->status"
            />

            <button type="submit"
                    class="bg-emerald-700 text-white px-5 py-2 rounded-lg hover:bg-emerald-800">
                Update Status
            </button>

        </form>
    </div>
    <div class="bg-white border rounded-xl p-5 shadow-sm">

        <h2 class="text-lg font-semibold text-slate-800">
            Schedule a Mediation Hearing
        </h2>

        <p class="text-sm text-slate-500 mb-4">
            Set the hearing schedule and record its details.
        </p>

        <form action="{{ route('official.cases.hearings', $incident) }}"
              method="POST">

            @csrf

            <x-hearing-fields />

            <button type="submit"
                    class="bg-emerald-700 text-white px-5 py-2 rounded-lg hover:bg-emerald-800 mt-3">
                Save Hearing
            </button>

        </form>
    </div>

</div>

@endsection
