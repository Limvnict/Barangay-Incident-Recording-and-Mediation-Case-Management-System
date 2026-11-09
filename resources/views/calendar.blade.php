@extends('layout')

@section('content')

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Hearing Calendar</h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isOfficial ? 'Monitor all upcoming barangay mediation hearings.' : 'View upcoming hearings for your complaints.' }}
            </p>
        </div>

        <div class="bg-emerald-50 border border-emerald-100 rounded-xl px-5 py-3">
            <p class="text-xs font-medium text-emerald-700">Upcoming Hearings</p>
            <p class="text-2xl font-bold text-emerald-800">
                {{ $hearings->count() }}
            </p>
        </div>
    </div>

    {{-- Hearing List --}}
    @forelse ($hearings->groupBy(fn ($h) => $h->hearing_date->format('l, M d, Y')) as $day => $list)

        <div>
            <div class="flex items-center gap-2 mb-3">
                <div class="w-1 h-6 bg-emerald-600 rounded-full"></div>

                <h2 class="font-semibold text-gray-800">{{ $day }}</h2>

                <span class="text-xs bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full">
                    {{ $list->count() }}
                    {{ $list->count() === 1 ? 'hearing' : 'hearings' }}
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($list as $hearing)

                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:border-emerald-300 transition">

                        <div class="flex flex-wrap items-center justify-between gap-4">

                            <div class="flex items-center gap-4">

                                {{-- Date and Time --}}
                                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-center min-w-24">
                                    <p class="text-xs font-semibold text-emerald-700">
                                        {{ $hearing->hearing_date->format('M d, Y') }}
                                    </p>

                                    <p class="text-sm font-bold text-emerald-900 mt-1">
                                        {{ $hearing->hearing_date->format('g:i A') }}
                                    </p>
                                </div>

                                {{-- Hearing Information --}}
                                <div>
                                    <h3 class="font-semibold text-gray-800">
                                        {{ $hearing->stage }}
                                    </h3>

                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $hearing->incident->complainant_name }}
                                        <span class="text-gray-400">vs.</span>
                                        {{ $hearing->incident->respondent_name }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-2">
                                        Blotter No:
                                        <span class="font-medium text-gray-700">
                                            {{ $hearing->incident->blotter_no }}
                                        </span>
                                    </p>
                                </div>

                            </div>

                            {{-- View Case --}}
                            <a
                                href="{{ $isOfficial ? route('official.cases.show', $hearing->incident) : route('resident.dashboard.show', $hearing->incident) }}"
                                class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                View Case
                                <span>→</span>
                            </a>

                        </div>

                    </div>

                @endforeach
            </div>
        </div>

    @empty

        {{-- Empty State --}}
        <div class="bg-white border border-gray-200 rounded-xl p-12 text-center shadow-sm">

            <div class="flex justify-center mb-4">
                <div class="bg-emerald-50 rounded-full p-5">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-10 h-10 text-emerald-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                    </svg>
                </div>
            </div>

            <h2 class="text-lg font-semibold text-gray-800">
                No Upcoming Hearings
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                There are currently no scheduled mediation hearings.
            </p>

        </div>

    @endforelse

</div>

@endsection
