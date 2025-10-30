@extends('layouts.guest')

@section('title', 'Book Seats - ' . $show->movie->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="bi bi-ticket-perforated text-indigo-600"></i>
            {{ $show->movie->title }}
            <span class="text-sm font-normal text-gray-500">— {{ $show->screen->theatre->name }}</span>
        </h1>

        <a href="{{ url()->previous() }}"
            class="px-3 py-1.5 text-sm border border-gray-300 text-gray-600 rounded-md hover:bg-gray-50 transition">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <!-- Layout: Poster (left) + Seats (right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Movie Info -->
        <div class="bg-white border border-gray-100 shadow-sm rounded-xl p-5">
            <img src="{{ $show->movie->poster_url ?: 'https://via.placeholder.com/400x600?text=Poster' }}"
                alt="{{ $show->movie->title }}"
                class="w-full rounded-lg shadow mb-5 object-cover">

            <div>
                <h2 class="text-lg font-semibold text-gray-800 mb-1">{{ $show->movie->title }}</h2>
                <p class="text-sm text-gray-500 mb-3">
                    {{ $show->screen->theatre->name }} — {{ $show->screen->theatre->city ?? 'Unknown City' }}
                </p>

                <div class="text-sm text-gray-600 space-y-2">
                    <div><i class="bi bi-clock mr-1 text-gray-500"></i> Starts:
                        {{ \Carbon\Carbon::parse($show->starts_at)->format('d M, h:i A') }}
                    </div>
                    <div><i class="bi bi-tv mr-1 text-gray-500"></i> Screen: {{ $show->screen->name }}</div>
                    <div><i class="bi bi-translate mr-1 text-gray-500"></i> Language: {{ $show->movie->language ?? 'N/A' }}</div>
                    <div><i class="bi bi-film mr-1 text-gray-500"></i> Category: {{ $show->movie->category ?? 'N/A' }}</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="bg-gray-50 p-3 rounded-lg border text-sm text-gray-700">
                <div class="flex justify-between">
                    <span><i class="bi bi-box mr-1 text-gray-500"></i> Selected Seats:</span>
                    <span id="selectedCount">0</span>
                </div>
                <div class="flex justify-between mt-1">
                    <span><i class="bi bi-cash mr-1 text-gray-500"></i> Estimated Total:</span>
                    <span id="totalAmount">₹0</span>
                </div>
            </div>

            <form id="bookingForm" method="POST" action="{{ route('customer.bookings.store') }}" class="mt-5">
                @csrf
                <input type="hidden" name="show_id" value="{{ $show->id }}">
                <input type="hidden" id="selectedSeats" name="seats">

                <!-- Error Box -->
                @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg p-3">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <button type="submit"
                    class="w-full mt-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow transition">
                    <i class="bi bi-check-circle"></i> Confirm Booking
                </button>
            </form>

        </div>

        <!-- Right Column: Seat Layout -->
        <div class="lg:col-span-2">
            @if($seats->isEmpty())
            <div class="text-center text-gray-500 py-10 bg-white border rounded-lg">
                <i class="bi bi-exclamation-circle text-2xl"></i>
                <p class="mt-2">No seats available for this screen.</p>
            </div>
            @else
            <div class="overflow-x-auto border rounded-lg p-6 bg-gray-50 shadow-sm">
                @php
                $grouped = $seats->groupBy('row_label');
                @endphp

                <div class="flex flex-col gap-3">
                    @foreach($grouped as $rowLabel => $rowSeats)
                    <div class="flex items-center gap-3 justify-center">
                        <span class="w-6 text-gray-600 text-sm font-semibold">{{ $rowLabel }}</span>
                        @foreach($rowSeats as $seat)
                        <div title="Seat {{ $seat->seat_number }} ({{ ucfirst($seat->type) }}) - {{ ucfirst($seat->status) }}"
                            data-seat-id="{{ $seat->id }}"
                            data-price="{{ $seat->price_override ?? $show->base_price }}"
                            class="seat w-10 h-12 flex flex-col items-center justify-end text-center rounded-md cursor-pointer transition-transform hover:scale-105
                                            @if($seat->status === 'available') bg-green-500 text-white hover:bg-green-400
                                            @elseif($seat->status === 'pending') bg-yellow-400 text-white cursor-not-allowed
                                            @elseif($seat->status === 'booked') bg-blue-500 text-white cursor-not-allowed
                                            @else bg-red-600 text-white cursor-not-allowed @endif">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="w-5 h-5 mt-1">
                                <path d="M7 3a1 1 0 0 0-1 1v7H4a1 1 0 1 0 0 2h1v6a1 1 0 1 0 2 0v-3h10v3a1 1 0 1 0 2 0v-6h1a1 1 0 1 0 0-2h-2V4a1 1 0 0 0-1-1H7zm1 2h8v6H8V5z" />
                            </svg>
                            <span class="text-[10px] font-semibold leading-none mb-1">{{ $seat->col_number }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Seat Legend -->
            <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm text-gray-700">
                <div class="flex items-center gap-2"><span class="w-4 h-4 bg-green-500 rounded-sm"></span> Available</div>
                <div class="flex items-center gap-2"><span class="w-4 h-4 bg-yellow-400 rounded-sm"></span> Pending</div>
                <div class="flex items-center gap-2"><span class="w-4 h-4 bg-blue-500 rounded-sm"></span> Booked</div>
                <div class="flex items-center gap-2"><span class="w-4 h-4 bg-red-600 rounded-sm"></span> Blocked</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const selectedSeats = new Set();
        const $selectedInput = $('#selectedSeats');
        const $selectedCount = $('#selectedCount');
        const $totalAmount = $('#totalAmount');
        // const basePrice = {
        //     {
        //         $show -> base_price
        //     }
        // };

        // Seat selection
        $('.seat').on('click', function() {
            const $seat = $(this);
            const seatId = $seat.data('seat-id');
            const price = parseFloat($seat.data('price'));

            if ($seat.hasClass('bg-green-500')) {
                $seat.toggleClass('bg-green-500 bg-indigo-600');
                if (selectedSeats.has(seatId)) {
                    selectedSeats.delete(seatId);
                } else {
                    selectedSeats.add(seatId);
                }

                const seatArray = [...selectedSeats];
                $selectedInput.val(seatArray.join(','));
                $selectedCount.text(seatArray.length);
                $totalAmount.text('₹' + (seatArray.length * price));
            }
        });

        // Real-time updates via Laravel Echo (Pusher)
        if (typeof window.Echo !== 'undefined') {
            window.Echo.private(`show.{{ $show->id }}`)
                .listen('.booking.updated', function(e) {
                    if (!e.seats || !Array.isArray(e.seats)) return;
                    e.seats.forEach(item => {
                        const $tile = $(`[data-seat-id="${item.seat.id}"]`);
                        if ($tile.length) {
                            $tile
                                .removeClass('bg-green-500 bg-yellow-400 bg-blue-500 bg-red-600 bg-indigo-600')
                                .addClass(getSeatColor(item.seat.status))
                                .css('cursor', item.seat.status === 'available' ? 'pointer' : 'not-allowed');
                        }
                    });
                });
        }

        function getSeatColor(status) {
            const colors = {
                available: 'bg-green-500 cursor-pointer',
                pending: 'bg-yellow-400 cursor-not-allowed',
                booked: 'bg-blue-500 cursor-not-allowed',
                blocked: 'bg-red-600 cursor-not-allowed'
            };
            return colors[status] || 'bg-gray-400';
        }

        console.log('🎬 Seat Booking UI ready — Live updates active.');
    });
</script>
@endpush