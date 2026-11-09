@extends('layout')

@section('page-title', 'Notices')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Notices</h1>
            <p class="text-sm text-gray-500 mt-1">
                Stay updated with your complaint activities.
            </p>
        </div>

        <form action="{{ route('resident.notices.read') }}" method="POST">
            @csrf
            <button type="submit"
                class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                Mark all as read
            </button>
        </form>
    </div>

    <div class="space-y-3">
        @forelse ($notices as $notice)

            <div class="border rounded-xl p-5 shadow-sm
                {{ $notice->read_at
                    ? 'bg-white border-gray-200'
                    : 'bg-emerald-50 border-emerald-200' }}">

                <div class="flex items-start gap-3">

                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                        {{ $notice->read_at ? 'bg-gray-100' : 'bg-emerald-100' }}">
                        <span class="text-lg">
                            {{ $notice->read_at ? '📄' : '🔔' }}
                        </span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <p class="font-semibold text-gray-800">
                                {{ $notice->message }}
                            </p>

                            @if (!$notice->read_at)
                                <span class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full">
                                    New
                                </span>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            {{ $notice->created_at->diffForHumans() }}
                        </p>

                        @if ($notice->incident_id)
                            <a href="{{ route('resident.dashboard.show', $notice->incident_id) }}"
                                class="inline-block mt-3 text-sm font-semibold text-emerald-700 hover:text-emerald-900">
                                View Case &rarr;
                            </a>
                        @endif
                    </div>

                </div>
            </div>

        @empty
            <div class="bg-white border border-gray-200 rounded-xl p-10 text-center">
                <div class="text-4xl mb-3">📭</div>
                <h2 class="font-semibold text-gray-800">No Notices Yet</h2>
                <p class="text-sm text-gray-500 mt-1">
                    You will see updates about your complaints here.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notices->links() }}
    </div>

</div>
@endsection
