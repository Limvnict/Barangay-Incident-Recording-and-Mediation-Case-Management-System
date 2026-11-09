@extends('layout')

@section('page-title', 'Complaint Details')

@section('content')

    <div class="max-w-6xl mx-auto">

        {{-- Back to Dashboard --}}
        <a href="{{ route('resident.dashboard.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-900 mb-5">
            &larr; Back to Dashboard
        </a>

        {{-- Complaint Details --}}
        <div class="mt-2">
            <x-case-detail :incident="$incident" />
        </div>

    </div>

@endsection
