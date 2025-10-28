<header class="bg-white border-b">
    <div class="px-4 md:px-6 h-14 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <button class="md:hidden inline-flex items-center justify-center rounded p-2 hover:bg-gray-100"
                @click="sidebarOpen = !sidebarOpen" aria-label="Toggle Menu">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold hidden md:block">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="flex items-center gap-4">
            {{-- Search (optional) --}}
            <form action="{{ route('movies.index') }}" method="GET" class="hidden md:block">
                <input type="text" name="q" placeholder="Search movies..."
                    class="border rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring w-64">
            </form>

            {{-- User dropdown --}}
            <div class="relative">
                <details class="group">
                    <summary class="flex items-center gap-2 cursor-pointer list-none">
                        <span class="text-sm text-gray-700">{{ auth()->user()->name ?? 'User' }}</span>
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(auth()->user()->email ?? 'guest@example.com')) }}?s=40&d=identicon"
                            class="h-8 w-8 rounded-full border">
                    </summary>
                    <div class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow z-50 p-2">
                        <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded hover:bg-gray-50 text-sm">Profile</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-50 text-sm">Logout</button>
                        </form>
                    </div>
                </details>
            </div>
        </div>
    </div>
</header>