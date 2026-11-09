<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page-title', 'Dashboard') | Barangay Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">

    @php
        $isOfficial = auth()->check() && auth()->user()->isOfficial();
    @endphp

    <div class="min-h-screen flex flex-col md:flex-row">
        <aside class="w-full md:w-64 bg-emerald-950 text-white flex flex-col shrink-0">
            <div class="p-6 border-b border-emerald-800">
                <a href="/" class="block">
                    <h1 class="text-xl font-bold">Barangay<span class="text-emerald-400"></span></h1>
                    <p class="text-xs text-emerald-300 mt-1">Incident & Mediation System</p>
                </a>
            </div>
            @auth
                <nav class="p-4 flex-1">

                    <p class="text-xs uppercase tracking-wider text-emerald-400 font-semibold mb-3">
                        Main Menu
                    </p>

                    <div class="space-y-2">

                        @if($isOfficial)

                            <a href="{{ route('official.dashboard') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('official.dashboard') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>▦</span>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('official.calendar') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('official.calendar') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>▣</span>
                                <span>Mediation Calendar</span>
                            </a>

                            <a href="{{ route('official.reports') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('official.reports') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>▤</span>
                                <span>Reports & Statistics</span>
                            </a>

                            <a href="{{ route('official.sms') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('official.sms') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>✉</span>
                                <span>SMS Logs</span>
                            </a>

                        @else

                            <a href="{{ route('resident.dashboard.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('resident.dashboard.index') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>▦</span>
                                <span>My Dashboard</span>
                            </a>

                            <a href="{{ route('resident.dashboard.create') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('resident.dashboard.create') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>＋</span>
                                <span>File a Complaint</span>
                            </a>

                            <a href="{{ route('resident.calendar') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('resident.calendar') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>▣</span>
                                <span>Mediation Calendar</span>
                            </a>

                            <a href="{{ route('resident.notices.index') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('resident.notices.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>♧</span>
                                <span>Notifications</span>
                            </a>

                            <a href="{{ route('resident.profile.edit') }}"
                               class="flex items-center gap-3 px-4 py-3 rounded-lg
                               {{ request()->routeIs('resident.profile.*') ? 'bg-emerald-700 text-white' : 'text-emerald-100 hover:bg-emerald-900' }}">
                                <span>◉</span>
                                <span>My Profile</span>
                            </a>

                        @endif

                    </div>
                </nav>
            @endauth

        </aside>
        <div class="flex-1 min-w-0 flex flex-col">

            <header>
                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div>
                        @auth
                            <h2 class="font-semibold text-slate-800"></h2>
                        @endauth
                    </div>

                    @auth
                        <div class="flex items-center gap-3">

                            <span class="hidden sm:inline-block text-xs font-medium bg-emerald-100 text-emerald-800 px-3 py-2 rounded-full">
                                {{ $isOfficial ? 'Barangay Official' : 'Resident' }}
                            </span>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-slate-600 border border-slate-300 px-4 py-2 rounded-lg hover:bg-slate-100">
                                    Log out
                                </button>
                            </form>

                        </div>
                    @endauth

                </div>
            </header>
            <main class="flex-1 p-4 md:p-6 lg:p-8">

                <div class="max-w-7xl mx-auto">

                    @if(session('success'))
                        <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 p-4 rounded-lg mb-5">
                            {{ session('success') }}
                        </div>
                    @elseif(session('ok'))
                        <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 p-4 rounded-lg mb-5">
                            {{ session('ok') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-200 text-red-800 p-4 rounded-lg mb-5">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @yield('content')

                </div>

            </main>

        </div>

    </div>

</body>
</html>
