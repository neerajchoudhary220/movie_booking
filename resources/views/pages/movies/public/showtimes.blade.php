@extends('layouts.guest')

@section('title', $movie->title . ' - Showtimes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 min-h-screen">

    <!-- Filter Bar -->
    <form method="GET" class="mb-8 flex flex-col sm:flex-row items-center justify-between gap-3">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-calendar-week text-indigo-600"></i>
            Select Date
        </h2>
        <div class="flex items-center gap-3">
            <input type="date"
                name="date"
                value="{{ $date }}"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <button
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-1">
                <i class="bi bi-search"></i> Filter
            </button>
            @if(request('date') && request('date') !== now()->toDateString())
            <a href="{{ route('movies.showtimes', $movie) }}"
                class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 text-gray-700 flex items-center gap-1">
                <i class="bi bi-x-circle"></i> Clear
            </a>
            @endif
        </div>
    </form>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: Movie Info -->
        <div class="lg:col-span-1 bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <img src="{{ $movie->poster_url ?: 'https://via.placeholder.com/400x600?text=Poster' }}"
                alt="{{ $movie->title }}"
                class="w-full rounded-lg shadow mb-5 object-cover">

            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $movie->title }}</h1>

            @if($movie->release_date)
            <p class="text-sm text-gray-500 mb-3">
                Released on {{ $movie->release_date->format('d M Y') }}
            </p>
            @endif

            <p class="text-gray-700 leading-relaxed text-sm mb-5">
                {{ $movie->description ?? 'No description available for this movie.' }}
            </p>

            <div class="space-y-2 text-sm text-gray-700">
                <div class="flex items-center gap-2">
                    <i class="bi bi-tags text-indigo-500"></i>
                    <span><strong>Category:</strong> {{ $movie->category ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-clock text-indigo-500"></i>
                    <span><strong>Duration:</strong> {{ $movie->duration ? $movie->duration . ' min' : '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-translate text-indigo-500"></i>
                    <span><strong>Language:</strong> {{ $movie->language ?? '—' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="bi bi-circle-fill text-green-500 text-xs"></i>
                    <span><strong>Status:</strong> {{ ucfirst($movie->status) }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Showtimes -->
        <div class="lg:col-span-2">
            <h2 class="text-xl font-semibold text-gray-800 mb-5">
                🎟️ Available Showtimes on {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
            </h2>

            @forelse($shows as $show)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-4 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                    <div>
                        <div class="text-lg font-medium text-gray-800 flex items-center gap-2">
                            <i class="bi bi-tv text-indigo-500"></i>
                            {{ $show->screen->name }} — {{ $show->screen->theatre->name }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                            <i class="bi bi-geo-alt"></i>
                            {{ $show->screen->theatre->location ?? 'Unknown location' }},
                            {{ $show->screen->theatre->city ?? '' }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                            <i class="bi bi-clock"></i>
                            Starts at:
                            <span class="font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($show->starts_at)->format('h:i A') }}
                            </span>
                        </div>
                    </div>

                    <!-- Booking Button -->
                    @auth
                    <a href="{{route('bookings.create',$show)}}"
                        class="mt-3 sm:mt-0 inline-flex items-center justify-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition">
                        <i class="bi bi-ticket-perforated"></i> Book Now
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="mt-3 sm:mt-0 inline-flex items-center justify-center gap-2 px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                        <i class="bi bi-box-arrow-in-right"></i> Login to Book
                    </a>
                    @endauth
                </div>
            </div>
            @empty
            <div class="text-gray-500 text-center py-10">
                <i class="bi bi-exclamation-circle text-2xl"></i>
                <p class="mt-2">No shows available for this date.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection