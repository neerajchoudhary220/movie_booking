@extends('layouts.app')

@section('title', 'Movies')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
        <h1 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="bi bi-film text-indigo-600"></i>
            Movies
        </h1>

        @can('create movies', App\Models\Movie::class)
        <a href="{{ route('admin.movies.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="bi bi-plus-circle"></i> Add Movie
        </a>
        @endcan
    </div>

    <!-- Search -->
    <x-action.search-bar
        route="{{ route('admin.movies.index') }}"
        placeholder="Search by title, category, or language" />


    <!-- Movie Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full border divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Title</th>
                    <th class="px-4 py-3 text-left">Category</th>
                    <th class="px-4 py-3 text-left">Language</th>
                    <th class="px-4 py-3 text-left">Duration</th>
                    <th class="px-4 py-3 text-left">Release Date</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($movies as $index => $movie)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500">{{ $movies->firstItem() + $index }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $movie->title }}</td>
                    <td class="px-4 py-3">{{ $movie->category ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $movie->language ?? '—' }}</td>
                    <td class="px-4 py-3">{{ $movie->duration ? $movie->duration . ' min' : '—' }}</td>
                    <td class="px-4 py-3">{{ $movie->release_date ? $movie->release_date->format('d M Y') : '—' }}</td>
                    <td class="px-4 py-3">
                        <span
                            class="inline-block px-2 py-0.5 rounded text-xs font-medium 
                            {{ $movie->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ ucfirst($movie->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right flex justify-end gap-2">
                        <a href="{{ route('admin.movies.show', $movie) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 border border-gray-300 text-gray-700 rounded text-sm hover:bg-gray-50 transition">
                            <i class="bi bi-eye"></i> View
                        </a>
                        @can('edit movies', $movie)
                        <a href="{{ route('admin.movies.edit', $movie) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-500 transition">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @endcan
                        @can('delete movies', $movie)
                        <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
                            onsubmit="return confirm('Delete this movie?');">
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
                    <td colspan="8" class="text-center py-5 text-gray-500">No movies found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $movies->links('vendor.pagination.tailwind') }}
    </div>
</div>
@endsection