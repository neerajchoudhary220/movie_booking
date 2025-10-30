@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Manage Users</h1>

        <a href="{{ route('admin.users.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
            + Add Manager
        </a>


    </div>
    <x-action.search-bar placeholder="Search by name" :route="route('admin.users.index')" />
    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex gap-6">
            <a href="{{ route('admin.users.index', ['tab' => 'customers']) }}"
                class="pb-2 border-b-2 text-sm font-medium {{ $activeTab === 'customers' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Customers
            </a>
            <a href="{{ route('admin.users.index', ['tab' => 'managers']) }}"
                class="pb-2 border-b-2 text-sm font-medium {{ $activeTab === 'managers' ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                Managers
            </a>
        </nav>
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Role</th>
                    @if(request()->get('tab')==='managers')
                    <th class="px-6 py-3 text-right">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                $list = $activeTab === 'managers' ? $managers : $customers;
                @endphp

                @forelse($list as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3">{{ $user->name }}</td>
                    <td class="px-6 py-3">{{ $user->email }}</td>
                    <td class="px-6 py-3 capitalize">{{ $user->getRoleNames()->implode(', ') }}</td>
                    @can('edit users',$user)
                    @if(request()->get('tab')==='managers' && $user->hasRole('Manager'))

                    <td class="px-4 py-3 text-right flex justify-end gap-2 flex-wrap">

                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="flex items-center justify-center gap-1 px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-500 transition">
                            <i class="bi bi-pencil"></i> Edit

                    </td>
                    </a>
                    @endif
                    @endcan
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection