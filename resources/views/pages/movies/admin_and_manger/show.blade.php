@extends('layouts.app')

@section('title', 'Movie Details')

@section('content')
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-film text-indigo-600"></i>
            {{ $movie->title }}
        </h1>

        <a href="{{ route('admin.movies.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <!-- Poster + Details -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Movie Poster -->
        <div class="md:col-span-1 flex justify-center">
            <img src="{{ $movie->poster_url 
        ? asset('storage/' . $movie->poster_url) 
        : 'https://placehold.co/400x600/EEE/888?text=Poster+Unavailable' }}"
                alt="{{ $movie->title }} Poster"
                class="w-full max-w-xs h-auto rounded-lg border border-gray-200 shadow-sm object-cover">
        </div>

        <!-- Movie Information -->
        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div>
                <div class="text-gray-500">Category</div>
                <div class="font-medium text-gray-800">{{ $movie->category ?? '—' }}</div>
            </div>

            <div>
                <div class="text-gray-500">Language</div>
                <div class="font-medium text-gray-800">{{ $movie->language ?? '—' }}</div>
            </div>

            <div>
                <div class="text-gray-500">Duration</div>
                <div class="font-medium text-gray-800">{{ $movie->duration ? $movie->duration . ' min' : '—' }}</div>
            </div>

            <div>
                <div class="text-gray-500">Release Date</div>
                <div class="font-medium text-gray-800">
                    {{ $movie->release_date ? $movie->release_date->format('d M Y') : '—' }}
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="text-gray-500">Description</div>
                <div class="font-medium text-gray-800 leading-relaxed">
                    {{ $movie->description ?? '—' }}
                </div>
            </div>

            <div>
                <div class="text-gray-500">Status</div>
                <span class="inline-block px-2 py-1 text-xs rounded
                    {{ $movie->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                    {{ ucfirst($movie->status) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex gap-3">
        @can('update', $movie)
        <a href="{{ route('admin.movies.edit', $movie) }}"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endcan

        @can('delete', $movie)
        <form method="POST" action="{{ route('admin.movies.destroy', $movie) }}"
            onsubmit="return confirm('Delete this movie?');">
            @csrf @method('DELETE')
            <button
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection