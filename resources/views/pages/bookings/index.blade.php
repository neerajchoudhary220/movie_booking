@extends('layouts.app')

@section('title', 'Manage Bookings')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Bookings</h1>
    </div>

    <!-- 🔍 Search Bar -->
    <x-action.search-bar
        route="{{ route('admin.bookings.index') }}"
        placeholder="Search customer, movie, theatre, or seat..." />

    <!-- Bookings Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow border border-gray-200 mt-4">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Movie</th>
                    <th class="px-4 py-3">Theatre</th>
                    <th class="px-4 py-3">Show Time</th>
                    <th class="px-4 py-3">Seats</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $booking->id }}</td>
                    <td class="px-4 py-3">{{ $booking->user->name }}</td>
                    <td class="px-4 py-3">{{ $booking->show->movie->title }}</td>
                    <td class="px-4 py-3">{{ $booking->show->screen->theatre->name }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($booking->show->starts_at)->format('d M, h:i A') }}
                    </td>
                    <td class="px-4 py-3">{{ $booking->items->pluck('seat.seat_number')->join(', ') }}</td>
                    <td class="px-4 py-3">₹{{ number_format($booking->total_amount, 2) }}</td>
                    <td class="px-4 py-3">
                        <span
                            @class([ 'px-2 py-1 rounded text-xs font-semibold' , 'bg-yellow-100 text-yellow-800'=> $booking->status === 'pending',
                            'bg-green-100 text-green-800' => $booking->status === 'confirmed',
                            'bg-red-100 text-red-800' => $booking->status === 'cancelled',
                            'bg-gray-100 text-gray-800' => $booking->status === 'expired',
                            ])>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right flex justify-end gap-2 flex-wrap">
                        <form action="{{route('admin.bookings.update',$booking)}}" method="POST" class="inline-flex gap-2">

                            @can('create bookings', $booking)
                            @csrf @method('PUT')
                            <select name="status" class="border rounded px-3 py-1 text-xs">
                                <option value="confirmed" @selected($booking->status==='confirmed')>Confirm</option>
                                <option value="cancelled" @selected($booking->status==='cancelled')>Cancel</option>
                            </select>
                            <button type="submit" class="px-3 py-1 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
                                Update
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-6 text-center text-gray-500">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection