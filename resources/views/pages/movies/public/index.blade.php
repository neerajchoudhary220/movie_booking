@extends('layouts.guest')

@section('title', 'Movies')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 bg-gray-50 min-h-screen">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-3 sm:mb-0">🎬 Now Showing</h1>

        <form method="GET" class="flex flex-wrap items-center gap-3 bg-white px-4 py-3 rounded-xl shadow-sm border border-gray-100">
            <input name="q" placeholder="Search movies" value="{{ request('q') }}" class="border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />

            <input name="date" type="date" value="{{ request('date') }}" class="border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" />

            <select name="category" class="border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">All Categories</option>
                @foreach(\App\Models\Movie::select('category')->distinct()->pluck('category') as $c)
                <option value="{{ $c }}" {{ request('category') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>

            <button class="px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg">Filter</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($movies as $movie)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition overflow-hidden">
            <div class="relative">
                <img src="{{ $movie->poster_url ?? 'https://via.placeholder.com/640x360?text=Poster' }}" class="w-full h-56 object-cover rounded-t-2xl">
                <span class="absolute top-2 left-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">
                    {{ $movie->category ?? 'Uncategorized' }}
                </span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ $movie->title }}</h3>
                <div class="text-sm text-gray-500 mt-1">Duration: {{ $movie->duration ?? 'N/A' }} min</div>
                <div class="text-sm text-gray-500">Language: {{ $movie->language ?? '—' }}</div>
                <p class="text-sm text-gray-600 mt-3 line-clamp-3">{{ $movie->description }}</p>

                <a href="{{route('movies.showtimes',$movie)}}" class="inline-flex items-center justify-center mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg">
                    View Showtimes
                </a>
            </div>
        </div>

        @empty
        <div class="col-span-full text-gray-500 text-center py-10">No movies found.</div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $movies->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection