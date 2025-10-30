@extends('layouts.app')

@section('title', 'Seats - ' . $screen->name)

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="bi bi-grid-3x3-gap text-indigo-600"></i>
                Seats — {{ $screen->name }}
            </h1>
            <div class="text-sm text-gray-500 mt-1">
                <i class="bi bi-building text-gray-500"></i> Theatre: <span class="font-medium text-gray-800">{{ $screen->theatre->name }}</span>
                • {{ $screen->theatre->city ?? '-' }}, {{ $screen->theatre->state ?? '-' }}
                • Capacity: <span class="font-semibold text-gray-700">{{ $screen->capacity }}</span>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('screens.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-1">
                <i class="bi bi-arrow-left-circle"></i> Back to Screens
            </a>
            @can('create', [App\Models\Seat::class, $screen])
            <a href="{{ route('screens.seats.create', $screen) }}"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-1">
                <i class="bi bi-plus-circle"></i> Add
            </a>
            <form method="POST" action="{{ route('screens.seats.generate', $screen) }}"
                onsubmit="return confirm('Generate layout? Existing seats will not be duplicated.');">
                @csrf
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-1">
                    <i class="bi bi-grid-1x2"></i> Auto Generate
                </button>
            </form>
            @endcan
        </div>
    </div>

    @if($seats->isEmpty())
    <div class="text-center text-gray-500 py-10">
        No seats found. Generate layout or add seats manually.
    </div>
    @else
    <div class="overflow-x-auto border rounded-lg p-6 bg-gray-50">
        @php
        $grouped = $seats->groupBy('row_label');
        @endphp

        <div class="flex flex-col gap-3">
            @foreach($grouped as $rowLabel => $rowSeats)
            <div class="flex items-center gap-3 justify-center">
                <span class="w-6 text-gray-600 text-sm font-semibold">{{ $rowLabel }}</span>

                @foreach($rowSeats as $seat)
                <div title="Seat {{ $seat->seat_number }} ({{ ucfirst($seat->type) }}) - {{ ucfirst($seat->status) }}"
                    data-seat-id="{{ $seat->id }}" @class(['base-class seat-tile w-10 h-12 flex flex-col items-center justify-end text-center rounded-md cursor-pointer transition-transform hover:scale-105', 'bg-green-500 text-white'=> $seat->status === 'available',
                    'bg-yellow-400 text-white' => $seat->status === 'pending',
                    'bg-blue-500 text-white' => $seat->status === 'booked',
                    'bg-red-600 text-white' => $seat->status === 'blocked',
                    ])>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-5 h-5 mt-1">
                        <path
                            d="M7 3a1 1 0 0 0-1 1v7H4a1 1 0 1 0 0 2h1v6a1 1 0 1 0 2 0v-3h10v3a1 1 0 1 0 2 0v-6h1a1 1 0 1 0 0-2h-2V4a1 1 0 0 0-1-1H7zm1 2h8v6H8V5z" />
                    </svg>
                    <span class="text-[10px] font-semibold leading-none mb-1">{{ $seat->col_number }} </span>
                </div>

                @endforeach
            </div>
            @endforeach
        </div>

    </div>

    <div class="mt-8 flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-4 text-sm text-gray-700">

        <div class="flex flex-wrap justify-center gap-4">
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-green-500 rounded-sm"></span>
                Available (<span id="count-available">{{ $availableCount }}</span>)
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-yellow-400 rounded-sm"></span>
                Pending (<span id="count-pending">{{ $pendingCount }}</span>)
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-blue-500 rounded-sm"></span>
                Booked (<span id="count-booked">{{ $bookedCount }}</span>)
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-red-600 rounded-sm"></span>
                Blocked (<span id="count-blocked">{{ $blockedCount }}</span>)
            </div>
        </div>

        <div class="text-gray-600 text-sm font-medium bg-gray-100 border rounded-lg px-4 py-2">
            Total Seats: <span class="text-gray-800 font-semibold" id="count-total">{{ $totalSeats }}</span>
        </div>
    </div>



    @endif
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const updateCounters = (counts) => {
            document.querySelector('#count-available').textContent = counts.available;
            document.querySelector('#count-pending').textContent = counts.pending;
            document.querySelector('#count-booked').textContent = counts.booked;
            document.querySelector('#count-blocked').textContent = counts.blocked;
            document.querySelector('#count-total').textContent = counts.total;
        };

        document.querySelectorAll('.seat-tile').forEach(tile => {
            tile.addEventListener('click', async (e) => {
                const seatId = tile.dataset.seatId;
                const screenId = "{{ $screen->id }}";
                const url = `/screens/${screenId}/seats/${seatId}/toggle`;

                tile.classList.add('opacity-60');

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });

                    const data = await res.json();
                    if (data.success) {
                        // ✅ Update tile color
                        tile.classList.remove('bg-green-500', 'bg-red-600');
                        if (data.new_status === 'blocked') {
                            tile.classList.add('bg-red-600', 'text-white');
                        } else {
                            tile.classList.add('bg-green-500', 'text-white');
                        }

                        // Update counts
                        updateCounters(data.counts);
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error toggling seat.');
                } finally {
                    tile.classList.remove('opacity-60');
                }
            });
        });
    });
</script>
@endpush