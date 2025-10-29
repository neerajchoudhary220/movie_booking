@extends('layouts.app')

@section('title', 'Show Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-calendar-event text-indigo-600"></i>
            Show Details
        </h1>

        <a href="{{ route('shows.index') }}"
            class="text-sm text-indigo-600 hover:text-indigo-700 transition">
            <i class="bi bi-arrow-left-circle"></i> Back to Shows
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-film text-gray-500"></i> Movie
            </div>
            <div class="font-medium text-gray-800">{{ $show->movie->title }}</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-display text-gray-500"></i> Screen
            </div>
            <div class="font-medium text-gray-800">{{ $show->screen->name }}</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-building text-gray-500"></i> Theatre
            </div>
            <div class="font-medium text-gray-800">
                {{ $show->theatre->name }}
                <div class="text-xs text-gray-500">
                    {{ $show->theatre->city ?? '' }}, {{ $show->theatre->state ?? '' }} ({{ $show->theatre->pincode ?? '' }})
                </div>
            </div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-clock text-gray-500"></i> Start Time
            </div>
            <div class="font-medium text-gray-800">{{ $show->starts_at->format('d M Y, h:i A') }}</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-hourglass-split text-gray-500"></i> End Time
            </div>
            <div class="font-medium text-gray-800">{{ $show->ends_at?->format('d M Y, h:i A') ?? '—' }}</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-currency-rupee text-gray-500"></i> Base Price
            </div>
            <div class="font-medium text-gray-800">₹{{ number_format($show->base_price, 2) }}</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-lock text-gray-500"></i> Lock Duration
            </div>
            <div class="font-medium text-gray-800">{{ $show->lock_minutes }} minutes</div>
        </div>

        <div>
            <div class="text-gray-500 flex items-center gap-1">
                <i class="bi bi-bar-chart text-gray-500"></i> Status
            </div>
            <span class="inline-block px-2 py-1 text-xs rounded font-medium
                @class([
                    'bg-green-100 text-green-700' => $show->status === 'scheduled',
                    'bg-blue-100 text-blue-700' => $show->status === 'running',
                    'bg-gray-100 text-gray-600' => $show->status === 'completed',
                    'bg-red-100 text-red-700' => $show->status === 'cancelled',
                ])">
                {{ ucfirst($show->status) }}
            </span>
        </div>
    </div>

    <!-- Price Map Section -->
    @if(!empty($show->price_map))
    <div class="mt-6">
        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2 mb-3">
            <i class="bi bi-cash-stack text-indigo-600"></i> Seat Pricing
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach($show->price_map as $type => $price)
            <div class="border rounded-lg p-3 bg-gray-50">
                <div class="text-gray-600 font-medium capitalize">{{ $type }}</div>
                <div class="text-lg font-bold text-gray-800">₹{{ number_format($price, 2) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Created & Updated Info -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
        <div>
            <span class="font-medium text-gray-500">Created At:</span>
            <span class="text-gray-800">{{ $show->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <div>
            <span class="font-medium text-gray-500">Last Updated:</span>
            <span class="text-gray-800">{{ $show->updated_at->format('d M Y, h:i A') }}</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex gap-3">
        @can('update', $show)
        <a href="{{ route('shows.edit', $show) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
        @endcan

        @can('delete', $show)
        <form method="POST" action="{{ route('shows.destroy', $show) }}"
            onsubmit="return confirm('Are you sure you want to delete this show?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                <i class="bi bi-trash3"></i> Delete
            </button>
        </form>
        @endcan
    </div>
</div>
@endsection