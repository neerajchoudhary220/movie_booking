@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">All Bookings</h2>
        <a href="{{ route('bookings.create') }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
            + New Booking
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Movie</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Show</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Seats</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($bookings as $index => $booking)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $bookings->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $booking->user->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $booking->show->movie->title ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $booking->show->screen->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $booking->seats ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            ₹{{ number_format($booking->total_amount, 2) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                            {{ $booking->created_at->format('d M Y, h:i A') }}
                        </td>
                        <td class="px-4 py-3">
                            @if ($booking->status === 'confirmed')
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200">
                                Confirmed
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                {{ ucfirst($booking->status) }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                            No bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $bookings->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection