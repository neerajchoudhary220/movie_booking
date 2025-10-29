@extends('layouts.app')

@section('title','Create Theatre')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Create Theatre</h1>

    <form action="{{ route('theatres.store') }}" method="POST">
        @csrf
        @include('pages.theaters._form')
        <div class="mt-4">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Create</button>
            <a href="{{ route('theatres.index') }}" class="ml-2 text-sm text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection