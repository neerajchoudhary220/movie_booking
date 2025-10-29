@extends('layouts.app')

@section('title','Theatres')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Theatres</h1>
        @can('create theatres')
        <a href="{{route('theatres.create')}}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">+ New Theatre</a>
        @endcan
    </div>

    <!-- Search -->
    <x-action.search-bar
        route="{{ route('theatres.index') }}"
        placeholder="Search name, city or code" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($theatres as $theatre)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition overflow-hidden">
            <div class="p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-building text-indigo-600"></i>
                            {{ $theatre->name }}
                        </h2>

                        {{-- Address Section --}}
                        <div class="mt-2 text-sm text-gray-600 space-y-0.5">
                            <div class="flex items-center gap-2">
                                <i class="bi bi-geo-alt text-gray-400"></i>
                                <span>{{ $theatre->location ?? '—' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="bi bi-pin-map text-gray-400"></i>
                                <span>
                                    {{ $theatre->city ?? '—' }},
                                    {{ $theatre->state ?? '—' }}
                                    @if($theatre->pincode)
                                    — {{ $theatre->pincode }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Manager Section --}}
                        <div class="text-sm text-gray-500 mt-2">
                            <i class="bi bi-person-workspace text-gray-400 mr-1"></i>
                            Manager:
                            @if($theatre->manager)
                            <span class="text-gray-700 font-medium">{{ $theatre->manager->name }}</span>
                            <span class="text-xs text-gray-400">({{ $theatre->manager->email }})</span>
                            @else
                            <span class="inline-block ml-1 px-2 py-0.5 text-xs rounded bg-red-100 text-red-700 font-medium">
                                Not Assigned
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="text-right">
                        <span class="inline-block px-2 py-1 text-xs rounded {{ $theatre->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($theatre->status) }}
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="mt-5 flex gap-2">
                    <a href="{{ route('theatres.show', $theatre) }}"
                        class="flex items-center justify-center gap-1 px-3 py-1.5 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50 transition">
                        <i class="bi bi-eye"></i> View
                    </a>

                    @can('update', $theatre)
                    <a href="{{ route('theatres.edit', $theatre) }}"
                        class="flex items-center justify-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-500 transition">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    @endcan

                    @can('delete', $theatre)
                    <form action="{{ route('theatres.destroy', $theatre) }}" method="POST" onsubmit="return confirm('Delete this theatre?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-sm hover:bg-red-500 transition">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-gray-500 text-center py-10">
            <i class="bi bi-exclamation-circle text-2xl text-gray-400"></i>
            <p class="mt-2">No theatres found.</p>
        </div>
        @endforelse
    </div>


    <div class="mt-6">
        {{ $theatres->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection