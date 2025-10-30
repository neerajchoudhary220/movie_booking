@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md px-8 py-10 bg-white rounded-2xl shadow-lg border border-gray-100">
        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Movie<span class="text-indigo-600">Book</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2">Login to your account</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-center text-green-600" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <x-text-input id="password"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="password"
                    name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Remember Me + Forgot -->
            <div class="flex items-center justify-between mt-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-indigo-600 hover:text-indigo-700 transition">
                    {{ __('Forgot password?') }}
                </a>
                @endif
            </div>

            <!-- Button -->
            <div class="pt-2">
                <x-primary-button
                    class="w-full justify-center py-2.5 text-base font-semibold bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 ease-in-out">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="flex items-center justify-center my-6">
            <div class="border-t border-gray-200 w-1/4"></div>
            <span class="text-gray-400 text-sm mx-2">or</span>
            <div class="border-t border-gray-200 w-1/4"></div>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-gray-600 text-sm">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition">
                    Sign up
                </a>
            </p>
        </div>
    </div>
</div>
@endsection