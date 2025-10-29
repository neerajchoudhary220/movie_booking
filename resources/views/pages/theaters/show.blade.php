@extends('layouts.app')

@section('title', 'View Theatre')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-8 border border-gray-100">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-building text-indigo-600 text-xl"></i>
            {{ $theatre->name }}
        </h1>

        <a href="{{ route('theatres.index') }}"
            class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700 transition">
            <i class="bi bi-arrow-left-circle mr-1"></i> Back to Theatres
        </a>
    </div>

    <!-- Theatre Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <!-- Address Section -->
        <div class="col-span-1 md:col-span-2 bg-gray-50 border rounded-lg p-4">
            <div class="text-gray-500 font-medium mb-1">Address</div>
            <div class="text-gray-800">
                <i class="bi bi-geo-alt text-indigo-500 mr-1"></i>
                {{ $theatre->location ?? '-' }}
                <br>
                <span class="text-gray-600">
                    {{ $theatre->city ?? '-' }},
                    {{ $theatre->state ?? '-' }}
                    @if($theatre->pincode)
                    — {{ $theatre->pincode }}
                    @endif
                </span>
            </div>
        </div>

        <!-- Manager Section -->
        <div>
            <div class="text-gray-500 font-medium">Manager</div>
            <div class="font-medium text-gray-800 mt-1">
                @if($theatre->manager)
                <i class="bi bi-person-workspace text-indigo-500 mr-1"></i>
                {{ $theatre->manager->name }}
                <div class="text-gray-500 text-xs mt-0.5">
                    <i class="bi bi-envelope"></i> {{ $theatre->manager->email }}
                </div>
                @else
                <span class="inline-block px-2 py-1 text-xs rounded bg-red-100 text-red-700 font-medium">
                    Not Assigned
                </span>
                @endif
            </div>
        </div>

        <!-- Status -->
        <div>
            <div class="text-gray-500 font-medium">Status</div>
            <span class="inline-flex items-center gap-1 mt-1 px-3 py-1 text-xs rounded-full font-semibold 
                {{ $theatre->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                <i class="bi {{ $theatre->status === 'active' ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                {{ ucfirst($theatre->status) }}
            </span>
        </div>

        <!-- Created At -->
        <div>
            <div class="text-gray-500 font-medium">Created At</div>
            <div class="font-medium text-gray-800 mt-1">
                {{ $theatre->created_at ? $theatre->created_at->format('d M Y, h:i A') : '-' }}
            </div>
        </div>

        <!-- Updated At -->
        <div>
            <div class="text-gray-500 font-medium">Last Updated</div>
            <div class="font-medium text-gray-800 mt-1">
                {{ $theatre->updated_at ? $theatre->updated_at->format('d M Y, h:i A') : '-' }}
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-10 flex flex-wrap items-center gap-3">
        @can('update', $theatre)
        <a href="{{ route('theatres.edit', $theatre) }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
        @endcan

        @can('delete', $theatre)
        <form method="POST" action="{{ route('theatres.destroy', $theatre) }}"
            onsubmit="return confirm('Are you sure you want to delete this theatre?');">
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