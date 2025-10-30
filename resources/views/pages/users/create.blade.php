@extends('layouts.app')

@section('title', 'Add Manager')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white rounded-xl shadow border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Add New Manager</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" type="text" name="name" class="w-full mt-1" :value="old('name')" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" class="w-full mt-1" :value="old('email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" class="w-full mt-1" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="w-full mt-1" />
        </div>

        <div class="flex justify-end">
            <x-primary-button>
                {{ __('Create Manager') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endsection