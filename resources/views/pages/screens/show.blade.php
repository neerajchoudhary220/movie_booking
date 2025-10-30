@extends('layouts.app')

@section('title', 'Screen Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-display text-indigo-600"></i> {{ $screen->name }}
        </h1>

        <a href="{{ route('screens.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
            <i class="bi bi-arrow-left-circle"></i> Back to Screens
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div>
            <div class="text-gray-500">Theatre</div>
            <div class="font-medium text-gray-800"><a href="{{route('theatres.show',$screen->theatre)}}" class="text-blue-600 hover:underline">{{ $screen->theatre->name }}</a></div>
        </div>

        <div>
            <div class="text-gray-500">Capacity</div>
            <div class="font-medium text-gray-800">{{ $screen->capacity }}</div>
        </div>

        <div>
            <div class="text-gray-500">Layout</div>
            <div class="font-medium text-gray-800">{{ $screen->rows }} Rows × {{ $screen->cols }} Columns</div>
        </div>

        <div>
            <div class="text-gray-500">Status</div>
            <span class="inline-block px-2 py-1 text-xs rounded font-medium
                {{ $screen->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($screen->status) }}
            </span>
        </div>
    </div>

    <div class="mt-8 flex gap-3">
        @can('update', $screen)
        <a href="{{ route('screens.edit', $screen) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
        @endcan

        @can('delete', $screen)
        <form method="POST" action="{{ route('screens.destroy', $screen) }}"
            onsubmit="return confirm('Are you sure you want to delete this screen?');">
            @csrf @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="bi bi-trash3"></i> Delete
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection