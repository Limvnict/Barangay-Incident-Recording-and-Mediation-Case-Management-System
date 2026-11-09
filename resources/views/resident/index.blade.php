@extends('layout')

@section('page-title', 'Resident Dashboard')

@section('content')

    @php
        $filed = $statusCounts['Filed'] ?? 0;
        $mediation = $statusCounts['Under Mediation'] ?? 0;
        $settled = $statusCounts['Settled'] ?? 0;
        $otherCases = $totalComplaints - $filed - $mediation - $settled;
    @endphp

    <div class="max-w-7xl mx-auto space-y-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-emerald-950">
                    Resident Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Welcome! Here you can monitor your complaints and mediation schedules.
                </p>
            </div>

            <a href="{{ route('resident.dashboard.create') }}"
                class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white px-5 py-3 rounded-lg font-semibold transition">
                <span>+</span> File a Complaint
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Total Complaints</p>
                <h2 class="text-3xl font-bold text-emerald-800 mt-2">
                    {{ $totalComplaints }}
                </h2>
                <p class="text-xs text-gray-400 mt-2">All submitted complaints</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Filed</p>
                <h2 class="text-3xl font-bold text-amber-600 mt-2">
                    {{ $filed }}
                </h2>
                <p class="text-xs text-gray-400 mt-2">Complaints received</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Under Mediation</p>
                <h2 class="text-3xl font-bold text-teal-600 mt-2">
                    {{ $mediation }}
                </h2>
                <p class="text-xs text-gray-400 mt-2">Cases being mediated</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">
                <p class="text-sm text-gray-500">Settled</p>
                <h2 class="text-3xl font-bold text-green-600 mt-2">
                    {{ $settled }}
                </h2>
                <p class="text-xs text-gray-400 mt-2">Successfully settled cases</p>
            </div>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-emerald-950">
                        Complaint Status Overview
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Distribution of your complaint records.
                    </p>
                </div>
                @if ($totalComplaints > 0)
                    <div class="h-72">
                        <canvas id="statusChart"></canvas>
                    </div>
                @else
                    <div class="h-72 flex items-center justify-center text-gray-400 text-sm">
                        No complaint data available.
                    </div>
                @endif
            </div>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-emerald-950">
                        Monthly Complaint Activity
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Your complaints during the last six months.
                    </p>
                </div>

                <div class="h-72">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

        </div>
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-emerald-950">
                    Complaint Progress
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Check the current progress of your complaints.
                </p>
            </div>

            @if ($totalComplaints > 0)

                @foreach ([
                    ['Filed', $filed, 'bg-amber-500'],
                    ['Under Mediation', $mediation, 'bg-teal-500'],
                    ['Settled', $settled, 'bg-green-600'],
                    ['Other Statuses', $otherCases, 'bg-gray-500']
                ] as $progress)

                    <div class="mb-6 last:mb-0">
                        <div class="flex justify-between items-center text-sm mb-2">
                            <span class="font-medium text-gray-700">
                                {{ $progress[0] }}
                            </span>

                            <span class="font-semibold text-gray-600">
                                {{ $progress[1] }}
                                <span class="text-gray-400 font-normal">
                                    ({{ round(($progress[1] / $totalComplaints) * 100) }}%)
                                </span>
                            </span>
                        </div>

                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="{{ $progress[2] }} h-2.5 rounded-full transition-all"
                                style="width: {{ ($progress[1] / $totalComplaints) * 100 }}%">
                            </div>
                        </div>
                    </div>

                @endforeach

            @else
                <p class="text-center text-gray-400 py-8">
                    No complaint records available.
                </p>
            @endif
        </div>
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-emerald-950">
                            Upcoming Hearings
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Your scheduled mediation sessions.
                        </p>
                    </div>

                    <a href="{{ route('resident.calendar') }}"
                        class="text-sm text-emerald-700 font-semibold hover:underline">
                        View Calendar
                    </a>
                </div>

                @forelse ($upcomingHearings as $hearing)

                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 py-4 last:border-0">
                        <div>
                            <p class="font-semibold text-gray-800">
                                {{ $hearing->incident->blotter_no ?? 'Complaint' }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $hearing->stage }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-emerald-700">
                                {{ \Carbon\Carbon::parse($hearing->hearing_date)->format('M d, Y') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($hearing->hearing_date)->format('h:i A') }}
                            </p>
                        </div>
                    </div>

                @empty
                    <p class="text-center text-gray-400 py-8 text-sm">
                        No upcoming hearings.
                    </p>
                @endforelse
            </div>

            {{-- Recent Notifications --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-bold text-emerald-950">
                            Recent Updates
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Latest updates about your complaints.
                        </p>
                    </div>

                    <a href="{{ route('resident.notices.index') }}"
                        class="text-sm text-emerald-700 font-semibold hover:underline">
                        View All
                    </a>
                </div>

                @forelse ($recentNotices as $notice)

                    <div class="border-b border-gray-100 py-4 last:border-0">
                        <p class="text-sm text-gray-700">
                            {{ $notice->message }}
                        </p>

                        <p class="text-xs text-gray-400 mt-2">
                            {{ $notice->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>

                @empty
                    <p class="text-center text-gray-400 py-8 text-sm">
                        No recent updates.
                    </p>
                @endforelse
            </div>

        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

            <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
                <div>
                    <h2 class="text-lg font-bold text-emerald-950">
                        My Complaint History
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Search and view your submitted complaint records.
                    </p>
                </div>

                <a href="{{ route('resident.dashboard.create') }}"
                    class="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition">
                    + New Complaint
                </a>
            </div>
            <form method="GET"
                action="{{ route('resident.dashboard.index') }}"
                class="flex flex-col sm:flex-row gap-2 mb-5">

                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Enter your blotter number..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <button type="submit"
                    class="bg-emerald-700 hover:bg-emerald-800 text-white px-6 py-3 rounded-lg text-sm font-semibold transition">
                    Search
                </button>

                @if ($search)
                    <a href="{{ route('resident.dashboard.index') }}"
                        class="border border-gray-300 hover:bg-gray-100 px-5 py-3 rounded-lg text-sm text-center transition">
                        Clear
                    </a>
                @endif

            </form>

            @if ($incidents->count())

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-emerald-50 text-emerald-950">
                            <tr>
                                <th class="p-4 font-semibold">Blotter Number</th>
                                <th class="p-4 font-semibold">Incident Type</th>
                                <th class="p-4 font-semibold">Date</th>
                                <th class="p-4 font-semibold">Status</th>
                                <th class="p-4 font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($incidents as $incident)
                                <tr class="border-b border-gray-100 hover:bg-emerald-50/40 transition">

                                    <td class="p-4 font-semibold text-gray-800">
                                        {{ $incident->blotter_no }}
                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ $incident->incident_type }}
                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ $incident->incident_date?->format('M d, Y') }}
                                    </td>

                                    <td class="p-4">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            {{ $incident->status }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <a href="{{ route('resident.dashboard.show', $incident) }}"
                                            class="text-emerald-700 font-semibold hover:underline">
                                            View Details
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-5">
                    {{ $incidents->links() }}
                </div>

            @else

                <div class="text-center py-12">
                    <div class="text-4xl mb-3">📋</div>

                    @if ($search)
                        <h3 class="font-semibold text-gray-700">
                            No matching complaint found.
                        </h3>

                        <p class="text-sm text-gray-400 mt-2">
                            Check your blotter number and try again.
                        </p>
                    @else
                        <h3 class="font-semibold text-gray-700">
                            No complaints submitted yet.
                        </h3>

                        <p class="text-sm text-gray-400 mt-2">
                            Your complaint records will appear here.
                        </p>
                    @endif
                </div>

            @endif

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const statusLabels = @json($statusLabels);
        const statusData = @json($statusData);
        const monthlyLabels = @json($monthlyLabels);
        const monthlyData = @json($monthlyData);

        const statusCanvas = document.getElementById('statusChart');

        if (statusCanvas) {
            new Chart(statusCanvas, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            '#F59E0B',
                            '#0D9488',
                            '#16A34A',
                            '#8B5CF6',
                            '#64748B',
                            '#EF4444'
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        const monthlyCanvas = document.getElementById('monthlyChart');

        if (monthlyCanvas) {
            new Chart(monthlyCanvas, {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Complaints',
                        data: monthlyData,
                        backgroundColor: '#059669',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>

@endsection
