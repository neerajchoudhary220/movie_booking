@extends('layouts.app')

@section('title', 'Add Show')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-sm border">
    <h1 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="bi bi-plus-circle text-indigo-600"></i> Add Show
    </h1>

    <form method="POST" action="{{ route('shows.update',$show) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('pages.shows._form')
        <div class="mt-6">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
            <a href="{{ route('shows.index') }}" class="ml-2 text-sm text-gray-600 hover:text-indigo-600">Cancel</a>
        </div>
    </form>
</div>
@endsection