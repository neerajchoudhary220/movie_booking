@extends('layouts.guest')

@section('title', 'Access Denied')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 text-center">
    <h1 class="text-6xl font-bold text-indigo-600 mb-4">403</h1>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Access Denied</h2>
    <p class="text-gray-500 mb-6">You don’t have permission to view this page.</p>
    <a href="{{ route('dashboard') }}"
        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
        Go to Dashboard
    </a>
</div>
@endsection