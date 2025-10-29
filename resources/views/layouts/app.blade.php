{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-100">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        {{-- Sidebar (desktop) --}}
        <aside class="hidden md:flex md:w-64 md:flex-col bg-white border-r">
            @include('layouts._partials.sidebar')
        </aside>

        {{-- Mobile sidebar overlay --}}
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 bg-black/40 z-30 md:hidden" @click="sidebarOpen=false"></div>
        {{-- Sidebar (mobile) --}}
        <aside
            x-show="sidebarOpen" x-cloak
            class="fixed z-40 inset-y-0 left-0 w-64 bg-white border-r p-2 md:hidden">
            @include('layouts._partials.sidebar')
        </aside>

        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            @include('layouts._partials.header')

            {{-- Main content --}}
            <main class="flex-1 p-4 md:p-6">
                @yield('breadcrumbs')
                @yield('content')
            </main>

            {{-- Footer --}}
            @include('layouts._partials.footer')
        </div>
    </div>

    @stack('scripts')
</body>

</html>