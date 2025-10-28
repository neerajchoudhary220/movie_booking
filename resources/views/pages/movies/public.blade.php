@extends('layouts.guest')

@section('title', 'Movies')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-4">Now Showing</h1>

    <form method="GET" class="mb-4 flex items-center gap-3">
        <input name="date" type="date" class="border rounded px-3 py-2">
        <select name="category" class="border rounded px-3 py-2">
            <option value="">All Categories</option>
            <option>Sci-Fi</option>
            <option>Action</option>
            <option>Comedy</option>
            <option>Drama</option>
        </select>
        <button class="px-4 py-2 rounded bg-gray-900 text-white">Filter</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @forelse($movies as $movie)
        <div class="bg-white border rounded-xl overflow-hidden">
            <img src="{{ $movie->poster_url ?? 'https://via.placeholder.com/640x360?text=Poster' }}" class="w-full h-40 object-cover">
            <div class="p-4">
                <div class="font-semibold">{{ $movie->title }}</div>
                <div class="text-xs text-gray-500">{{ $movie->category }} • {{ $movie->duration }} min</div>
                <a href="{{ route('movies.showtimes', $movie) }}" class="inline-block mt-3 text-sm px-3 py-1.5 rounded bg-gray-900 text-white">View Showtimes</a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-gray-500">No movies found.</div>
        @endforelse
    </div>
</div>
@endsection