@extends('layouts.guest')

@section('title', $movie->title . ' - Showtimes')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10 bg-gray-50 min-h-screen">

    <!-- Movie Header -->
    <div class="flex flex-col sm:flex-row items-start gap-6 mb-10">
        <!-- Poster -->
        <img src="{{ $movie->poster_url ?: 'https://via.placeholder.com/160x240?text=Poster' }}"
            alt="{{ $movie->title }}"
            class="w-40 h-60 object-cover rounded-lg shadow-md border border-gray-200">

        <!-- Movie Details -->
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-800">{{ $movie->title }}</h1>
            @if($movie->release_date)
            <p class="text-sm text-gray-500 mt-1">
                Released on {{ $movie->release_date->format('d M Y') }}
            </p>
            @endif

            <p class="text-gray-600 mt-3 leading-relaxed">
                {{ $movie->description ?? 'No description available.' }}
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-y-2 mt-4 text-sm text-gray-600">
                <div>
                    <span class="font-semibold text-gray-700">🎭 Category:</span>
                    {{ $movie->category ?? '—' }}
                </div>
                <div>
                    <span class="font-semibold text-gray-700">⏱ Duration:</span>
                    {{ $movie->duration ? $movie->duration . ' min' : '—' }}
                </div>
                <div>
                    <span class="font-semibold text-gray-700">🌐 Language:</span>
                    {{ $movie->language ?? '—' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Date Selector -->
    <form method="GET" class="mb-6 flex flex-col sm:flex-row items-center gap-3">
        <input type="date"
            name="date"
            value="{{ $date }}"
            class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        <button
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-1">
            <i class="bi bi-calendar-event"></i> Filter
        </button>

        @if(request('date') && request('date') !== now()->toDateString())
        <a href="{{ route('movies.showtimes', $movie) }}"
            class="px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg hover:bg-gray-200 text-gray-700 flex items-center gap-1">
            <i class="bi bi-x-circle"></i> Clear
        </a>
        @endif
    </form>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        🎟️ Available Showtimes ({{ \Carbon\Carbon::parse($date)->format('d M Y') }})
    </h2>

    <!-- Showtimes -->
    @forelse($shows as $show)
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-4">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <div class="text-lg font-medium text-gray-800">
                    <i class="bi bi-tv text-indigo-500"></i>
                    {{ $show->screen->name }} — {{ $show->screen->theatre->name }}
                </div>
                <div class="text-sm text-gray-500 mt-1">
                    <i class="bi bi-geo-alt"></i> {{ $show->screen->theatre->location ?? 'Unknown location' }}
                </div>
                <div class="text-sm text-gray-500">
                    Starts at:
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($show->starts_at)->format('h:i A') }}
                    </span>
                </div>
            </div>

            <!-- Booking Button -->
            @auth
            <a href="{{ route('bookings.create', ['show' => $show->id]) }}"
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
@endsection