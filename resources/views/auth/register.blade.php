@extends('layout')

@section('page-title', 'Register')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-8">

    <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

        <div class="text-center mb-8">
    
            <h1 class="text-2xl font-bold text-gray-800">
                Create an Account
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Register
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

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <x-input-field label="Name" name="name"
                autocomplete="name" autofocus
                :value="old('name')" />

            <x-input-field label="Email" name="email"
                type="email" autocomplete="email"
                :value="old('email')" />

            <x-input-field label="Phone number"
                name="phone" type="tel"
                :value="old('phone')" />

            <x-input-field label="Password" name="password"
                type="password" autocomplete="new-password" />

            <x-input-field label="Confirm Password"
                name="password_confirmation"
                type="password" autocomplete="new-password" />

            <button type="submit"
                class="w-full bg-emerald-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition cursor-pointer mt-2">
                Create Account
            </button>
        </form>

        @if (Route::has('login'))
            <p class="text-sm text-center text-gray-600 mt-6">
                Already registered?
                <a href="{{ route('login') }}"
                    class="text-emerald-700 font-semibold hover:underline">
                    Log In
                </a>
            </p>
        @endif

        <div class="border-t border-gray-100 mt-6 pt-5 text-center">
            <p class="text-xs text-gray-400">
                Barangay Incident Case Recording and Mediation Management System
            </p>
        </div>

    </div>
</div>
@endsection
