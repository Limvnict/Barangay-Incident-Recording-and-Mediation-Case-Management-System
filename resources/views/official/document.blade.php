@php
    $titles = ['summons' => 'SUMMONS', 'notice' => 'NOTICE OF HEARING', 'settlement' => 'AMICABLE SETTLEMENT'];
    $when = $hearing ? $hearing->hearing_date->format('F d, Y \a\t g:i A') : '____________________';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $titles[$type] }} - {{ $incident->blotter_no }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-900">
    <div class="max-w-2xl mx-auto p-10">
        <button onclick="window.print()" class="print:hidden mb-6 bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer">Print</button>

        <div class="text-center mb-8">
            <p>Republic of the Philippines</p>
            <p class="font-bold">BARANGAY ____________________</p>
            <p>Office of the Lupong Tagapamayapa</p>
            <h1 class="text-2xl font-bold mt-6">{{ $titles[$type] }}</h1>
        </div>

        <p class="mb-1"><b>Blotter No.:</b> {{ $incident->blotter_no }}</p>
        <p class="mb-1"><b>Complainant:</b> {{ $incident->complainant_name }}</p>
        <p class="mb-6"><b>Respondent:</b> {{ $incident->respondent_name }}</p>

        @if ($type === 'summons')
            <p class="mb-4">TO: <b>{{ $incident->respondent_name }}</b></p>
            <p class="mb-4">You are hereby summoned to appear before the Punong Barangay on <b>{{ $when }}</b> at the Barangay Hall
                for mediation of the complaint filed by {{ $incident->complainant_name }} regarding
                <b>{{ $incident->incident_type }}</b> that happened on {{ $incident->incident_date->format('F d, Y') }} at {{ $incident->location }}.</p>
            <p class="mb-4">Your failure to appear without a valid reason may lead to the action allowed by the Katarungang Pambarangay law.</p>
        @elseif ($type === 'notice')
            <p class="mb-4">TO: <b>{{ $incident->complainant_name }}</b> and <b>{{ $incident->respondent_name }}</b></p>
            <p class="mb-4">Please be informed that the <b>{{ $hearing?->stage ?? 'hearing' }}</b> of the above case is scheduled on
                <b>{{ $when }}</b> at the Barangay Hall. Both parties are required to attend.</p>
        @else
            <p class="mb-4">The parties above met before the Barangay and freely agreed to settle their dispute
                ({{ $incident->incident_type }}) under the following terms:</p>
            <div class="mb-4 space-y-5">
                <p>1. ______________________________________________________________</p>
                <p>2. ______________________________________________________________</p>
                <p>3. ______________________________________________________________</p>
            </div>
            <p class="mb-8">Done this ____ day of ______________, {{ now()->year }}, at the Barangay Hall.</p>
        @endif

        <div class="grid grid-cols-2 gap-8 mt-16 text-center text-sm">
            @if ($type === 'settlement')
                <div><div class="border-t border-gray-800 pt-1">{{ $incident->complainant_name }}<br>Complainant</div></div>
                <div><div class="border-t border-gray-800 pt-1">{{ $incident->respondent_name }}<br>Respondent</div></div>
            @endif
            <div class="col-span-2 flex justify-end">
                <div class="border-t border-gray-800 pt-1 w-64">Punong Barangay</div>
            </div>
        </div>

        @if ($type === 'summons')
            <p class="mt-10 text-sm">Received by: ____________________ Date: ____________</p>
        @endif
    </div>
</body>
</html>
