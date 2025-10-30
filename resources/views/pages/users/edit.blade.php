@extends('layouts.app')

@section('title', 'Edit Manager')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white rounded-xl shadow border border-gray-100">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Manager</h2>

    @include('pages.users._form', ['user' => $user])

</div>
@endsection