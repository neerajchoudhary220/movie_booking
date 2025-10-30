@extends('layouts.app')

@section('title', 'Edit Movie')

@section('content')
<div class="max-w-3xl mx-auto bg-white border border-gray-100 rounded-xl shadow-sm p-6">
    <h1 class="text-xl font-semibold mb-5 text-gray-800 flex items-center gap-2">
        <i class="bi bi-pencil-square text-indigo-600"></i> Edit Movie
    </h1>

    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('pages.movies.admin_and_manger._form', ['movie' => $movie])

        <div class="mt-6">
            <x-primary-button>{{ __('Update Movie') }}</x-primary-button>
            <a href="{{ route('admin.movies.index') }}" class="ml-2 text-sm text-gray-600 hover:text-indigo-600">Cancel</a>
        </div>
    </form>
</div>
@endsection