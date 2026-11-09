
@extends('layout')

@section('content')

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">SMS Logs</h1>
            <p class="text-sm text-gray-500 mt-1">
                View the history of notification messages recorded by the system.
            </p>
        </div>

        <div class="bg-emerald-50 border border-emerald-100 rounded-xl px-5 py-3">
            <p class="text-xs font-medium text-emerald-700">Total Messages</p>
            <p class="text-2xl font-bold text-emerald-800">
                {{ $logs->total() }}
            </p>
        </div>
    </div>
    <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4">
        <div class="text-amber-600 text-xl">ⓘ</div>
        <div>
            <p class="font-semibold text-amber-800 text-sm">
                Simulated SMS Notifications
            </p>
            <p class="text-sm text-amber-700 mt-1">
                Messages are currently saved in the system only.
                They are not actually sent to mobile numbers.
                A real SMS provider, such as Semaphore, can be integrated later.
            </p>
        </div>
    </div>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-gray-800">Message History</h2>
            <span class="text-xs text-gray-500">
                {{ $logs->count() }} messages on this page
            </span>
        </div>

        @forelse ($logs as $log)

            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-3 shadow-sm hover:border-emerald-300 transition">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div class="flex items-center gap-3">
                        <div class="bg-emerald-50 rounded-full p-3">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 text-emerald-700"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M8 10h8m-8 4h5m-9 5 1.5-4.5A8 8 0 1 1 20 12a8 8 0 0 1-8 8H4z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Recipient</p>
                            <p class="font-semibold text-gray-800">
                                {{ $log->to_number }}
                            </p>
                        </div>
                    </div>

                    <div class="text-right">
                        <span class="inline-flex items-center bg-gray-100 text-gray-600 text-xs font-medium px-3 py-1 rounded-full">
                            Simulated
                        </span>

                        <p class="text-xs text-gray-500 mt-2">
                            {{ $log->created_at->format('M d, Y') }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ $log->created_at->format('g:i A') }}
                        </p>
                    </div>

                </div>

                <div class="border-t border-gray-100 mt-4 pt-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        Message Content
                    </p>

                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $log->message }}
                    </p>
                </div>

            </div>

        @empty
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
                                  d="M8 10h8m-8 4h5m-9 5 1.5-4.5A8 8 0 1 1 20 12a8 8 0 0 1-8 8H4z"/>
                        </svg>
                    </div>
                </div>

                <h2 class="text-lg font-semibold text-gray-800">
                    No SMS Records Yet
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Notification messages will appear here when recorded by the system.
                </p>
            </div>

        @endforelse
    </div>
    @if ($logs->hasPages())
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            {{ $logs->links() }}
        </div>
    @endif

</div>

@endsection
