<header class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 md:px-6 h-16 flex items-center justify-between">
        <!-- Left: Logo + Menu Button -->
        <div class="flex items-center gap-3">
            <!-- Mobile Sidebar Toggle -->
            <button class="md:hidden inline-flex items-center justify-center rounded-lg p-2 hover:bg-gray-100 transition"
                @click="sidebarOpen = !sidebarOpen"
                aria-label="Toggle Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo / App Name -->
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 hover:text-indigo-600 transition hidden md:block">
                {{ config('app.name', 'MovieBook') }}
            </a>
        </div>

        <!-- Right: Search + User -->
        <div class="flex items-center gap-4">
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
                        <a href="{{ route('profile.edit') ?? '#' }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>