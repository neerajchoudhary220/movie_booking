@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Total Bookings</div>
        <div class="text-2xl font-bold mt-2">{{ $myBookings }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Confirmed</div>
        <div class="text-2xl font-bold mt-2">{{ $myConfirmed }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Cancelled</div>
        <div class="text-2xl font-bold mt-2">{{ $myCancelled }}</div>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('bookings.index') }}" class="inline-block px-4 py-2 bg-gray-900 text-white rounded-lg">
        View My Bookings
    </a>
</div>
@endsection