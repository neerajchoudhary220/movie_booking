@extends('layouts.app')

@section('title', 'Edit Screen')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="bi bi-pencil-square text-indigo-600"></i> Edit Screen
    </h1>

    <form method="POST" action="{{ route('screens.update', $screen) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('pages.screens._form')
        <div class="flex justify-end gap-3">
            <a href="{{ route('screens.index') }}" class="px-4 py-2 border rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Update Screen
            </button>
        </div>
    </form>
</div>
@endsection