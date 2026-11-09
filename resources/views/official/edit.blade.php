@extends('layout')

@section('page-title', 'Edit Complaint')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('official.cases.show', $incident) }}"
           class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
            &larr; Back to Case Details
        </a>

        <h1 class="text-2xl font-bold text-gray-800 mt-3">
            Edit Complaint
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Blotter Number: {{ $incident->blotter_no }}
        </p>
    </div>

    <form action="{{ route('official.cases.update', $incident) }}"
          method="POST"
          class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

        @csrf
        @method('PUT')

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                Complaint Information
            </h2>
            <p class="text-sm text-gray-500">
                Update the information recorded for this incident.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-5">
                <p class="font-semibold mb-1">Please check the following:</p>
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            <div>
                <x-input-field label="Complainant" name="complainant_name"
                    :value="old('complainant_name', $incident->complainant_name)" />
            </div>

            <div>
                <x-input-field label="Respondent" name="respondent_name"
                    :value="old('respondent_name', $incident->respondent_name)" />
            </div>

            <div>
                <x-input-field label="Respondent's mobile number"
                    name="respondent_contact" type="tel"
                    :value="old('respondent_contact', $incident->respondent_contact ?? '')" />
            </div>

            <div>
                <x-input-field label="Incident type" name="incident_type"
                    type="select"
                    :options="\App\Models\Incident::TYPES"
                    :value="old('incident_type', $incident->incident_type)" />
            </div>

            <div>
                <x-input-field label="Date of incident" name="incident_date"
                    type="date"
                    :value="old('incident_date', $incident->incident_date->format('Y-m-d'))" />
            </div>

            <div>
                <x-input-field label="Location" name="location"
                    :value="old('location', $incident->location)" />
            </div>

            <div class="md:col-span-2">
                <x-input-field label="Narrative" name="narrative"
                    type="textarea"
                    :value="old('narrative', $incident->narrative)" />
            </div>

        </div>

        <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-5 border-t border-gray-200">

            <button type="submit"
                class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-emerald-700 transition">
                Save Changes
            </button>

            <a href="{{ route('official.cases.show', $incident) }}"
                class="text-center border border-gray-300 text-gray-700 px-6 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition">
                Cancel
            </a>

        </div>
    </form>
</div>
@endsection