@extends('layouts.app')

@section('title', 'Add Movie')

@section('content')
<div class="max-w-3xl mx-auto bg-white border border-gray-100 rounded-xl shadow-sm p-6">
    <h1 class="text-xl font-semibold mb-5 text-gray-800 flex items-center gap-2">
        <i class="bi bi-plus-circle text-indigo-600"></i> Add New Movie
    </h1>
    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('pages.movies.admin_and_manger._form')

        <div class="mt-6">
            <x-primary-button>{{ __('Save Movie') }}</x-primary-button>
            <a href="{{ route('admin.movies.index') }}" class="ml-2 text-sm text-gray-600 hover:text-indigo-600">Cancel</a>
        </div>
    </form>
</div>
@endsection