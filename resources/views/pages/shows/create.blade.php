@extends('layouts.app')

@section('title', 'Add Show')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-sm border">
    <h1 class="text-xl font-semibold mb-4 flex items-center gap-2">
        <i class="bi bi-plus-circle text-indigo-600"></i> Add Show
    </h1>

    <form method="POST" action="{{ route('shows.store') }}" class="space-y-6">
        @csrf
        @include('pages.shows._form')
        <div class="flex justify-end">
            <x-primary-button>Save</x-primary-button>
        </div>
    </form>
</div>
@endsection