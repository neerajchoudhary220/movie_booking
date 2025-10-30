<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <a href="{{ url('/') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>

                <nav class="space-x-4">
                    <a href="{{ route('movies') }}" class="text-sm text-gray-600 hover:text-gray-900">Movies</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-600 hover:text-gray-900">Register</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t">
            <div class="max-w-7xl mx-auto px-4 py-4 text-sm text-gray-500">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>