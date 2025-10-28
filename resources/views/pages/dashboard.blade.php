@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
<div class="mb-4 text-sm text-gray-500">Home / Dashboard</div>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-500">Today’s Bookings</div>
        <div class="text-2xl font-bold mt-2">{{ $todayBookings ?? 0 }}</div>
    </div>
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-500">Avg. Occupancy</div>
        <div class="text-2xl font-bold mt-2">{{ $occupancy ?? '0%' }}</div>
    </div>
    <div class="bg-white border rounded-xl p-4">
        <div class="text-sm text-gray-500">Cancelled vs Confirmed</div>
        <div class="text-2xl font-bold mt-2">{{ $cancelVsConfirm ?? '0 / 0' }}</div>
    </div>
</div>
@endsection