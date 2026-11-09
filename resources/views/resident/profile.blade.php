@extends('layout')

@section('page-title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
        <p class="text-sm text-gray-500 mt-1">
            View and update your personal information.
        </p>
    </div>

    <form action="{{ route('resident.profile.update') }}" method="POST"
        class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">

        @csrf
        @method('PUT')

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-800">
                Personal Information
            </h2>
            <p class="text-sm text-gray-500">
                Keep your contact information updated.
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

        <div class="space-y-4">

            <x-input-field label="Name" name="name"
                :value="old('name', auth()->user()->name)" />

            <x-input-field label="Mobile number (used for SMS)" name="phone"
                type="tel"
                :value="old('phone', auth()->user()->phone ?? '')" />

            <x-input-field label="Address" name="address"
                :value="old('address', auth()->user()->address ?? '')" />

            <x-input-field label="Purok" name="purok"
                :value="old('purok', auth()->user()->purok ?? '')" />

        </div>

        <div class="mt-6 pt-5 border-t border-gray-200">
            <button type="submit"
                class="bg-emerald-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-emerald-700 transition">
                Save Profile
            </button>
        </div>

    </form>
</div>
@endsection
