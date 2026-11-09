@props(['title' => 'Barangay Case System'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
    @auth
        @php
            $isOfficial = auth()->user()->isOfficial();
            // unread notifications (only residents get them)
            $unread = $isOfficial ? collect() : auth()->user()->notices()->whereNull('read_at')->latest()->get();
        @endphp
    @endauth

    <div class="max-w-4xl mx-auto p-6">
        <header class="flex flex-wrap items-center justify-between gap-2 mb-6">
            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">Barangay Case System</a>

            <nav class="flex flex-wrap items-center gap-4 text-sm">
                @auth
                    @if ($isOfficial)
                        <a href="{{ route('official.dashboard') }}" class="text-gray-600 hover:underline">Dashboard</a>
                        <a href="{{ route('official.calendar') }}" class="text-gray-600 hover:underline">Calendar</a>
                        <a href="{{ route('official.reports') }}" class="text-gray-600 hover:underline">Reports</a>
                        <a href="{{ route('official.sms') }}" class="text-gray-600 hover:underline">SMS Log</a>
                    @else
                        <a href="{{ route('resident.dashboard.index') }}" class="text-gray-600 hover:underline">Dashboard</a>
                        <a href="{{ route('resident.calendar') }}" class="text-gray-600 hover:underline">Calendar</a>
                        <a href="{{ route('resident.profile.edit') }}" class="text-gray-600 hover:underline">Profile</a>
                        <a href="{{ route('resident.notices.index') }}" class="text-gray-600 hover:underline"> Notices
                            @if ($unread->count())
                                <span class="bg-red-600 text-white text-xs rounded-full px-2 py-0.5">{{ $unread->count() }}</span>
                            @endif
                        </a>
                        <a href="{{ route('resident.dashboard.create') }}"
                           class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700">+ File Complaint</a>
                    @endif

                    @if (Route::has('logout'))
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900 hover:underline cursor-pointer">Log out</button>
                        </form>
                    @endif
                @endauth
            </nav>
        </header>

        @if (session('success'))
            <x-alert>{{ session('success') }}</x-alert>
        @endif

        {{ $slot }}
    </div>

    @if (! empty($unread) && $unread->count())
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-lg">
                <h2 class="font-bold text-lg mb-3">New updates ({{ $unread->count() }})</h2>
                <ul class="text-sm text-gray-700 space-y-2 mb-4">
                    @foreach ($unread->take(5) as $notice)
                        <li>• {{ $notice->message }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('resident.notices.read') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 cursor-pointer">OK, got it</button>
                </form>
            </div>
        </div>
    @endif
</body>
</html>
