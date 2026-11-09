@extends('layout')
@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">File a Complaint</h1>
        <p class="text-sm text-gray-500 mt-1">
            Please provide the details of your complaint accurately.
        </p>
    </div>

    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-emerald-800">
            <strong>Important:</strong> Please provide truthful and complete
            information. Your complaint will be reviewed by authorized barangay officials.
        </p>
    </div>
    <form method="POST"
        action="{{ route('resident.dashboard.store') }}"
        class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

        @csrf

        <h2 class="text-lg font-semibold text-gray-800 mb-5">
            Complaint Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <!-- Respondent -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Respondent Name
                </label>
                <input
                    type="text"
                    name="respondent_name"
                    value="{{ old('respondent_name') }}"
                    placeholder="Enter the person's full name"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                @error('respondent_name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Incident Type
                </label>
                <select
                    name="incident_type"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                    <option value="">Select incident type</option>

                    @foreach(\App\Models\Incident::TYPES as $t)
                        <option value="{{ $t }}" @selected(old('incident_type') === $t)>
                            {{ $t }}
                        </option>
                    @endforeach

                </select>

                @error('incident_type')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Date of Incident
                </label>
                <input
                    type="date"
                    name="incident_date"
                    value="{{ old('incident_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                @error('incident_date')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Incident Location
                </label>
                <input
                    type="text"
                    name="location"
                    value="{{ old('location') }}"
                    placeholder="Enter where the incident happened"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">

                @error('location')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Incident Description
                </label>
                <textarea
                    name="narrative"
                    rows="6"
                    placeholder="Describe what happened, including important details..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('narrative') }}</textarea>

                @error('narrative')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>
        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-7 pt-5 border-t border-gray-200">

            <a href="{{ route('resident.dashboard.index') }}"
                class="text-center px-5 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium">
                Cancel
            </a>

            <button
                type="submit"
                class="px-6 py-3 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold transition">
                Submit Complaint
            </button>

        </div>

    </form>
</div>
@endsection
