@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Today's Bookings</div>
        <div class="text-2xl font-bold mt-2">{{ $todayBookings }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Occupancy</div>
        <div class="text-2xl font-bold mt-2">{{ $occupancy }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Cancelled vs Confirmed</div>
        <div class="text-2xl font-bold mt-2">{{ $cancelled }} / {{ $confirmed }}</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Theatres</div>
        <div class="text-2xl font-bold mt-2">{{ $theatreCount }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Screens</div>
        <div class="text-2xl font-bold mt-2">{{ $screenCount }}</div>
    </div>
    <div class="bg-white rounded-xl p-4 border">
        <div class="text-sm text-gray-500">Shows</div>
        <div class="text-2xl font-bold mt-2">{{ $showCount }}</div>
    </div>
</div>
@endsection