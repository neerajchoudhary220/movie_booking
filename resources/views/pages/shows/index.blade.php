@extends('layouts.app')

@section('title', 'Shows')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-calendar-event text-indigo-600"></i>
            Shows
        </h1>

        @can('create shows', App\Models\Show::class)
        <a href="{{ route('shows.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
            <i class="bi bi-plus-circle"></i> Add Show
        </a>
        @endcan
    </div>

    <!-- Search -->
    <x-action.search-bar
        route="{{ route('shows.index') }}"
        placeholder="Search by movie or theatre" />

    <!-- <form method="GET" class="mb-5 flex flex-col sm:flex-row gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by movie or theatre"
            class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-72 focus:ring-indigo-500 focus:border-indigo-500">
        <button type="submit"
            class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-700 font-medium transition">
            <i class="bi bi-search"></i> Search
        </button>
    </form> -->

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Movie</th>
                    <th class="px-4 py-3 text-left">Screen</th>
                    <th class="px-4 py-3 text-left">Theatre</th>
                    <th class="px-4 py-3 text-left">Starts</th>
                    <th class="px-4 py-3 text-left">Ends</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($shows as $index => $show)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $shows->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $show->movie->title }}</td>
                    <td class="px-4 py-3">{{ $show->screen->name }}</td>
                    <td class="px-4 py-3">{{ $show->theatre->name }}</td>
                    <td class="px-4 py-3">{{ $show->starts_at->format('d M Y, h:i A') }}</td>
                    <td class="px-4 py-3">{{ $show->ends_at?->format('h:i A') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium
                            @class([
                                'bg-green-100 text-green-700' => $show->status === 'scheduled',
                                'bg-blue-100 text-blue-700' => $show->status === 'running',
                                'bg-gray-100 text-gray-600' => $show->status === 'completed',
                                'bg-red-100 text-red-700' => $show->status === 'cancelled',
                            ])">
                            {{ ucfirst($show->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right flex justify-end gap-2">
                        @can('view shows', $show)
                        <a href="{{ route('shows.show',$show)}}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50 transition">
                            <i class="bi bi-eye"></i> View
                        </a>
                        @endcan
                        @can('edit shows', $show)
                        <a href="{{ route('shows.edit', $show)}}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-500 transition">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan
                        @can('delete shows', $show)
                        <form action="{{ route('shows.destroy', $show) }}" method="POST"
                            onsubmit="return confirm('Delete this show?');">
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
                    <td colspan="8" class="text-center py-5 text-gray-500">No shows found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $shows->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection