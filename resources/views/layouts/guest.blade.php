{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="bg-white border-b shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <!-- Logo / Brand -->
                <a href="{{ url('/') }}" class="text-lg font-semibold text-indigo-600 flex items-center gap-1">
                    <span class="text-gray-800">{{ config('app.name') }}</span>
                </a>
                <!-- Navigation -->
                <nav class="flex items-center gap-4">
                    <a href="{{ route('movies') }}"
                        class="text-sm px-2 py-1 rounded-md transition 
        {{ request()->routeIs('movies.*')? 'text-indigo-600 font-medium bg-indigo-50' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Movies
                    </a>

                    @auth
                    <!-- User Dropdown -->
                    <div class="relative">
                        <details class="group">
                            <summary
                                class="flex items-center gap-2 cursor-pointer list-none px-2 py-1 rounded-md hover:bg-gray-50 transition">
                                <span class="text-sm font-medium text-gray-700">
                                    {{ auth()->user()->name ?? 'Guest' }}
                                </span>
                                <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(auth()->user()->email ?? 'guest@example.com')) }}?s=40&d=identicon"
                                    class="h-9 w-9 rounded-full border border-gray-200 shadow-sm">
                            </summary>

                            <!-- Dropdown Menu -->
                            <div
                                class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-lg z-50 py-2 animate-fade-in">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm transition rounded-md 
                    {{ request()->routeIs('profile.*') ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-700' }}">
                                    <i class="bi bi-person-circle mr-1"></i> Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                    @csrf
                                    <button
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                                        <i class="bi bi-box-arrow-right mr-1"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </details>
                    </div>
                    @else
                    <a href="{{ route('login') }}"
                        class="text-sm px-2 py-1 rounded-md transition 
        {{ request()->routeIs('login') ? 'text-indigo-600 font-medium bg-indigo-50' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                        class="text-sm px-2 py-1 rounded-md transition 
        {{ request()->routeIs('register') ? 'text-indigo-600 font-medium bg-indigo-50' : 'text-gray-600 hover:text-indigo-600 hover:bg-gray-50' }}">
                        Register
                    </a>
                    @endauth
                </nav>

            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t mt-auto">
            <div class="max-w-7xl mx-auto px-4 py-4 text-sm text-gray-500 text-center">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    @stack('scripts')
</body>

</html>