@extends('layout')

@section('content')

@php
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
@endphp

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Reports & Statistics</h1>
        <p class="text-sm text-slate-500 mt-1">
            Overview and analysis of recorded barangay incidents
        </p>
    </div>
    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <h2 class="font-semibold text-slate-800 mb-3">Filter Reports</h2>

        <form method="GET" action="{{ route('official.reports') }}"
              class="grid grid-cols-1 sm:grid-cols-3 gap-3">

            <div>
                <label class="block text-sm text-slate-600 mb-1">Month</label>
                <select name="month" class="w-full border rounded-lg px-3 py-2">
                    <option value="">All Months</option>

                    @foreach($months as $number => $month)
                        <option value="{{ $number }}"
                            @selected((string) $selectedMonth === (string) $number)>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-slate-600 mb-1">Year</label>
                <select name="year" class="w-full border rounded-lg px-3 py-2">
                    <option value="">All Years</option>

                    @foreach($years as $year)
                        <option value="{{ $year }}"
                            @selected((string) $selectedYear === (string) $year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit"
                    class="bg-emerald-700 text-white px-5 py-2 rounded-lg hover:bg-emerald-800">
                    Apply Filter
                </button>

                <a href="{{ route('official.reports') }}"
                    class="border border-slate-300 px-4 py-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    Reset
                </a>
            </div>

        </form>

        <p class="text-xs text-slate-500 mt-3">
            @if($selectedMonth || $selectedYear)
                Showing filtered incident records.
            @else
                Showing all recorded incident records.
            @endif
        </p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Total Complaints</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $total }}</h2>
            <p class="text-xs text-slate-400 mt-2">Recorded incidents</p>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Settlement Rate</p>
            <h2 class="text-3xl font-bold text-emerald-700 mt-2">{{ $rate }}%</h2>
            <p class="text-xs text-slate-400 mt-2">Percentage of settled cases</p>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <p class="text-sm text-slate-500">Average Days to Settle</p>
            <h2 class="text-3xl font-bold text-slate-800 mt-2">{{ $avgDays }}</h2>
            <p class="text-xs text-slate-400 mt-2">Based on current settlement calculation</p>
        </div>

    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <h2 class="font-semibold text-slate-800">Cases by Status</h2>
            <p class="text-xs text-slate-500 mb-4">Distribution of incident statuses</p>

            <div class="h-72">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white border rounded-xl p-5 shadow-sm">
            <h2 class="font-semibold text-slate-800">Cases by Incident Type</h2>
            <p class="text-xs text-slate-500 mb-4">Types of complaints recorded</p>

            <div class="h-72">
                <canvas id="typeChart"></canvas>
            </div>
        </div>

    </div>
    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <h2 class="font-semibold text-slate-800">Monthly Incident Reports</h2>
        <p class="text-xs text-slate-500 mb-4">Number of incidents recorded each month</p>

        <div class="h-80">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="bg-white border rounded-xl p-5 shadow-sm">
        <h2 class="font-semibold text-slate-800">Top Incident Locations</h2>
        <p class="text-xs text-slate-500 mb-4">Locations with the highest number of recorded incidents</p>

        <div class="h-80">
            <canvas id="locationChart"></canvas>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const statusData = @json($byStatus);
    const typeData = @json($byType);
    const monthData = @json($byMonth);
    const locationData = @json($byLocation);
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#059669', '#f59e0b', '#3b82f6', '#64748b', '#ef4444'],
                borderWidth: 0
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
    new Chart(document.getElementById('typeChart'), {
        type: 'pie',
        data: {
            labels: Object.keys(typeData),
            datasets: [{
                data: Object.values(typeData),
                backgroundColor: [
                    '#059669', '#0d9488', '#14b8a6',
                    '#f59e0b', '#3b82f6', '#8b5cf6',
                    '#64748b', '#ef4444'
                ],
                borderWidth: 0
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

    // Monthly Incident Reports
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(monthData),
            datasets: [{
                label: 'Number of Incidents',
                data: Object.values(monthData),
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
            }
        }
    });

    // Top Incident Locations
    new Chart(document.getElementById('locationChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(locationData),
            datasets: [{
                label: 'Number of Incidents',
                data: Object.values(locationData),
                backgroundColor: '#0d9488',
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

@endsection