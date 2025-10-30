@extends('layouts.guest')
@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md px-8 py-10 bg-white rounded-2xl shadow-lg border border-gray-100">
        <!-- Logo / Title -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Movie<span class="text-indigo-600">Book</span>
            </h1>
            <p class="text-gray-500 text-sm mt-2">Create your account to start booking</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-gray-700" />
                <x-text-input id="name"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                <x-text-input id="password"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="password"
                    name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm"
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <x-primary-button
                    class="w-full justify-center py-2.5 text-base font-semibold bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 ease-in-out">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="flex items-center justify-center my-6">
            <div class="border-t border-gray-200 w-1/4"></div>
            <span class="text-gray-400 text-sm mx-2">or</span>
            <div class="border-t border-gray-200 w-1/4"></div>
        </div>

        <!-- Already Registered -->
        <div class="text-center">
            <p class="text-gray-600 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition">
                    Log in
                </a>
            </p>
        </div>
    </div>
</div>
@endsection