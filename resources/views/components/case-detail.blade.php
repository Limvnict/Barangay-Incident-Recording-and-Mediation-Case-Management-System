@props(['incident', 'editable' => false])

<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-6">
    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-5 mb-6">

        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">
                Blotter Number
            </p>

            <h2 class="text-2xl font-bold text-emerald-950 mt-1">
                {{ $incident->blotter_no }}
            </h2>
        </div>

        <span class="inline-flex items-center bg-emerald-100 text-emerald-800 px-4 py-2 rounded-full text-sm font-semibold">
            {{ $incident->status }}
        </span>

    </div>
    <div class="mb-6">

        <h3 class="text-lg font-bold text-emerald-950 mb-4">
            Incident Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <p class="text-xs text-gray-500 mb-1">Incident Type</p>
                <p class="font-semibold text-gray-800">
                    {{ $incident->incident_type }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-500 mb-1">Incident Date</p>
                <p class="font-semibold text-gray-800">
                    {{ $incident->incident_date->format('M d, Y') }}
                </p>
            </div>

            <div class="md:col-span-2">
                <p class="text-xs text-gray-500 mb-1">Incident Location</p>
                <p class="font-semibold text-gray-800">
                    {{ $incident->location }}
                </p>
            </div>

        </div>

    </div>

    <div class="border-t border-gray-100 my-6"></div>

    <div class="mb-6">

        <h3 class="text-lg font-bold text-emerald-950 mb-4">
            People Involved
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-5">
                <p class="text-xs text-emerald-700 font-semibold uppercase tracking-wide mb-2">
                    Complainant
                </p>

                <p class="font-bold text-gray-800">
                    {{ $incident->complainant_name }}
                </p>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wide mb-2">
                    Respondent
                </p>

                <p class="font-bold text-gray-800">
                    {{ $incident->respondent_name }}
                </p>

                @if ($editable && $incident->respondent_contact)
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $incident->respondent_contact }}
                    </p>
                @endif
            </div>

        </div>

    </div>
    <div>
        <h3 class="text-lg font-bold text-emerald-950 mb-3">
            Incident Description
        </h3>

        <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $incident->narrative }}</p>
        </div>
    </div>

</div>
<div class="mb-6">

    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">

        <div>
            <h2 class="text-xl font-bold text-emerald-950">
                Mediation Hearing History
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Scheduled hearings and recorded outcomes.
            </p>
        </div>

        <span class="bg-emerald-100 text-emerald-800 px-3 py-2 rounded-lg text-sm font-semibold">
            {{ $incident->hearings->count() }} Hearing(s)
        </span>

    </div>

    @forelse ($incident->hearings as $hearing)

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-4">

            {{-- Hearing Header --}}
            <div class="flex flex-wrap items-start justify-between gap-3">

                <div>
                    <h3 class="font-bold text-gray-800">
                        {{ $hearing->stage }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-2">
                        {{ $hearing->hearing_date->format('M d, Y - g:i A') }}
                    </p>
                </div>

                <span class="bg-emerald-50 text-emerald-800 border border-emerald-100 px-3 py-1.5 rounded-lg text-xs font-semibold">
                    {{ $hearing->outcome }}
                </span>

            </div>

            <div class="border-t border-gray-100 my-5"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Summons Status
                    </p>

                    <p class="text-sm font-semibold text-gray-800">
                        {{ $hearing->service_status }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Served By
                    </p>

                    <p class="text-sm font-semibold text-gray-800">
                        {{ $hearing->served_by ?? 'Not recorded' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500 mb-1">
                        Date Served
                    </p>

                    <p class="text-sm font-semibold text-gray-800">
                        {{ $hearing->served_date ? $hearing->served_date->format('M d, Y') : 'Not recorded' }}
                    </p>
                </div>

            </div>
            @if ($hearing->notes)

                <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 mt-5">

                    <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wide mb-2">
                        Notes / Agreement
                    </p>

                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $hearing->notes }}
                    </p>

                </div>

            @endif
            @if ($editable)

                <div class="flex flex-wrap items-center gap-4 mt-5 pt-4 border-t border-gray-100">

                    <a href="{{ route('official.hearings.edit', $hearing) }}"
                        class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                        Edit Hearing
                    </a>

                    <form action="{{ route('official.hearings.destroy', $hearing) }}"
                        method="POST"
                        onsubmit="return confirm('Delete this hearing?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="text-sm font-semibold text-red-600 hover:text-red-800">
                            Delete Hearing
                        </button>

                    </form>

                </div>

            @endif

        </div>

    @empty

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-10 text-center">

            <div class="text-4xl mb-3">📅</div>

            <h3 class="font-semibold text-gray-800">
                No hearings scheduled yet.
            </h3>

            <p class="text-sm text-gray-500 mt-2">
                Scheduled mediation hearings will appear here.
            </p>

        </div>

    @endforelse

</div>