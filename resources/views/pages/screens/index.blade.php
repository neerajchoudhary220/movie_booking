@extends('layouts.app')

@section('title', 'Screens')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-display text-indigo-600"></i> Screens
        </h1>

        @can('create', App\Models\Screen::class)
        <a href="{{ route('screens.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-plus-circle"></i> Add Screen
        </a>
        @endcan
    </div>

    <!-- Search -->
    <x-action.search-bar placeholder="Search by name or theatre" :route="route('screens.index')" />

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Screen</th>
                    <th class="px-4 py-3 text-left">Theatre</th>
                    <th class="px-4 py-3 text-left">Capacity</th>
                    <th class="px-4 py-3 text-left">Layout</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($screens as $index => $screen)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $screens->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $screen->name }}</td>
                    <td class="px-4 py-3 text-gray-700"><a href="{{route('theatres.show',$screen->theatre)}}" class="text-blue-600 hover:underline">{{ $screen->theatre->name }}</a></td>
                    <td class="px-4 py-3">{{ $screen->capacity }}</td>
                    <td class="px-4 py-3">{{ $screen->rows }} × {{ $screen->cols }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium
                        {{ $screen->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($screen->status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-right flex justify-end gap-2 flex-wrap">

                        @can('view screens', $screen)
                        <a href="{{ route('screens.show', $screen) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50 transition">
                            <i class="bi bi-eye"></i> View
                        </a>
                        @endcan

                        @can('edit screens', $screen)
                        <a href="{{ route('screens.edit', $screen) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-500 transition">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan

                        {{-- 🪑 Manage Seats Button --}}
                        @can('view seats', [App\Models\Seat::class, $screen])
                        <a href="{{ route('screens.seats.index', $screen) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-blue-600 text-white rounded text-sm hover:bg-blue-500 transition">
                            <i class="bi bi-grid-3x3-gap"></i> Seats
                        </a>
                        @endcan

                        @can('delete screens', $screen)
                        <form action="{{ route('screens.destroy', $screen) }}" method="POST"
                            onsubmit="return confirm('Delete this screen?');">
                            @csrf @method('DELETE')
                            <button
                                class="flex items-center justify-center gap-1 px-3 py-1.5 bg-red-600 text-white rounded text-sm hover:bg-red-500 transition">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-gray-500">No screens found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="mt-4">{{ $screens->links('vendor.pagination.tailwind') }}</div>
</div>
@endsection