@extends('layout')

@section('page-title', 'Log In')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-8">

        <div class="w-full max-w-md bg-white border border-gray-200 rounded-2xl shadow-sm p-8">

            <div class="text-center mb-8">

                <p class="text-sm text-gray-500 mt-2">
                    Log in to the Barangay Incident Management System.
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <x-input-field label="Email" name="email" type="email" autocomplete="email" autofocus
                    :value="old('email')" />

                <x-input-field label="Password" name="password" type="password" autocomplete="current-password" />

                <label class="flex items-center gap-2 mb-6 text-sm text-gray-700">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    Remember me
                </label>

                <button type="submit"
                    class="w-full bg-emerald-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-emerald-700 transition cursor-pointer">
                    Log In
                </button>
            </form>

            @if (Route::has('register'))
                <p class="text-sm text-center text-gray-600 mt-6">
                    No account yet?
                    <a href="{{ route('register') }}" class="text-emerald-700 font-semibold hover:underline">
                        Register as a Resident
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