@extends('layout')

@section('page-title', 'Official Dashboard')

@section('content')

@php
    $maxCount = max(array_merge([1], $counts->toArray()));
@endphp

<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex flex-wrap items-center justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-emerald-950">
                Official Dashboard
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Barangay Incident Case Recording and Management
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm">
            <p class="text-xs text-gray-400">Today's Date</p>
            <p class="text-sm font-semibold text-gray-700">
                {{ now()->format('F d, Y') }}
            </p>
        </div>

    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Total Cases</p>
                    <h2 class="text-3xl font-bold text-emerald-800 mt-3">
                        {{ $totalCases }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">
                        All recorded incidents
                    </p>
                </div>

                <div class="bg-emerald-50 text-emerald-700 rounded-lg p-3">
                    <span class="text-xl">📁</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Filed This Month</p>
                    <h2 class="text-3xl font-bold text-emerald-700 mt-3">
                        {{ $thisMonth }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">
                        {{ now()->format('F Y') }}
                    </p>
                </div>

                <div class="bg-emerald-50 text-emerald-700 rounded-lg p-3">
                    <span class="text-xl">📅</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-500">Filed Today</p>
                    <h2 class="text-3xl font-bold text-emerald-800 mt-3">
                        {{ $todayCases }}
                    </h2>
                    <p class="text-xs text-gray-400 mt-2">
                        Incidents recorded today
                    </p>
                </div>

                <div class="bg-emerald-50 text-emerald-700 rounded-lg p-3">
                    <span class="text-xl">📝</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
            <div class="flex justify-between items-start gap-2">
                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Most Common Incident</p>

                    <h2 class="text-lg font-bold text-emerald-800 mt-3 break-words">
                        {{ $mostCommon->incident_type ?? 'No records yet' }}
                    </h2>

                    <p class="text-xs text-gray-400 mt-2">
                        {{ $mostCommon ? $mostCommon->total . ' recorded cases' : 'Waiting for records' }}
                    </p>
                </div>

                <div class="bg-emerald-50 text-emerald-700 rounded-lg p-3 shrink-0">
                    <span class="text-xl">📊</span>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

        <div class="mb-6">
            <h2 class="text-lg font-bold text-emerald-950">
                Cases by Status
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Overview of all recorded incident statuses.
            </p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">

            @foreach(\App\Models\Incident::STATUSES as $s)

                <a href="{{ route('official.dashboard', ['status' => $s]) }}"
                    class="border border-gray-200 rounded-xl p-5 hover:border-emerald-400 hover:shadow-sm transition">

                    <p class="text-sm text-gray-500">
                        {{ $s }}
                    </p>

                    <h2 class="text-3xl font-bold text-emerald-800 mt-3">
                        {{ $counts[$s] ?? 0 }}
                    </h2>

                    <p class="text-xs text-emerald-700 font-semibold mt-3">
                        View cases →
                    </p>

                </a>

            @endforeach

        </div>

        <div class="border-t border-gray-100 pt-6">

            <h3 class="font-semibold text-gray-800 mb-5">
                Case Distribution
            </h3>

            @foreach(\App\Models\Incident::STATUSES as $s)

                @php
                    $count = $counts[$s] ?? 0;

                    $percentage = $totalCases > 0
                        ? ($count / $totalCases) * 100
                        : 0;
                @endphp

                <div class="mb-6 last:mb-0">

                    <div class="flex justify-between items-center text-sm mb-2">

                        <span class="font-medium text-gray-700">
                            {{ $s }}
                        </span>

                        <span class="font-semibold text-emerald-800">
                            {{ $count }}
                            <span class="text-gray-400 font-normal">
                                ({{ round($percentage) }}%)
                            </span>
                        </span>

                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">

                        <div class="bg-emerald-600 h-2.5 rounded-full transition-all"
                            style="width: {{ $percentage }}%">
                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100">

            <h2 class="text-lg font-bold text-emerald-950">
                Incident Records
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Search, filter, and manage recorded complaints.
            </p>

        </div>
        <form method="GET" class="p-5 bg-gray-50 border-b border-gray-100">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">

                <div class="md:col-span-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search blotter number or name..."
                        class="w-full border border-gray-300 bg-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="md:col-span-3">
                    <select
                        name="status"
                        class="w-full border border-gray-300 bg-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">

                        <option value="">All statuses</option>

                        @foreach(\App\Models\Incident::STATUSES as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>
                                {{ $s }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="md:col-span-3 flex gap-2">

                    <button type="submit"
                        class="flex-1 bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-3 rounded-lg text-sm font-semibold transition">
                        Filter
                    </button>

                    <a href="{{ route('official.dashboard') }}"
                        class="flex-1 border border-gray-300 bg-white hover:bg-gray-100 text-gray-600 px-4 py-3 rounded-lg text-sm text-center font-medium transition">
                        Reset
                    </a>

                </div>

            </div>

        </form>

        {{-- Incident Table --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-emerald-50 text-emerald-950">

                    <tr>
                        <th class="p-4 font-semibold whitespace-nowrap">Blotter No.</th>
                        <th class="p-4 font-semibold whitespace-nowrap">Complainant</th>
                        <th class="p-4 font-semibold whitespace-nowrap">Respondent</th>
                        <th class="p-4 font-semibold whitespace-nowrap">Incident Type</th>
                        <th class="p-4 font-semibold whitespace-nowrap">Date</th>
                        <th class="p-4 font-semibold whitespace-nowrap">Status</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($incidents as $i)

                        <tr class="border-b border-gray-100 hover:bg-emerald-50/40 transition">

                            <td class="p-4 whitespace-nowrap">
                                <a href="{{ route('official.cases.show', $i) }}"
                                    class="font-bold text-emerald-700 hover:underline">
                                    {{ $i->blotter_no }}
                                </a>
                            </td>

                            <td class="p-4 text-gray-700">
                                {{ $i->complainant_name }}
                            </td>

                            <td class="p-4 text-gray-700">
                                {{ $i->respondent_name }}
                            </td>

                            <td class="p-4 text-gray-700">
                                {{ $i->incident_type }}
                            </td>

                            <td class="p-4 text-gray-600 whitespace-nowrap">
                                {{ $i->incident_date->format('M d, Y') }}
                            </td>

                            <td class="p-4 whitespace-nowrap">

                                <span class="inline-block px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $i->status }}
                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="p-10 text-center">

                                <div class="text-4xl mb-3">📂</div>

                                <h3 class="font-semibold text-gray-700">
                                    No incident records found.
                                </h3>

                                <p class="text-sm text-gray-400 mt-1">
                                    Try changing your search or filter.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        <div class="p-5 border-t border-gray-100">
            {{ $incidents->links() }}
        </div>

    </div>

</div>

@endsection
