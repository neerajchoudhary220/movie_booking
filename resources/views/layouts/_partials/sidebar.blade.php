<aside
    class="hidden md:flex md:flex-col w-64 h-screen bg-white border-r border-gray-200 shadow-sm fixed left-0 top-0 z-40 transition-all duration-300">

    <!-- Brand / Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-100">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-gray-800 hover:text-indigo-600 transition">
            <i class="fa-solid fa-ticket text-indigo-600 mr-1"></i> Movie<span class="text-indigo-600">Book</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-4">
        <!-- Main Section -->
        <ul class="space-y-1">
            <li>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-speedometer2 text-gray-500 w-5 text-center"></i>
                        Dashboard
                    </div>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link :href="route('admin.movies.index')" :active="request()->routeIs('admin.movies.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-ticket-perforated text-gray-500 w-5 text-center"></i>
                        Movies
                    </div>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link :href="route('theatres.index')" :active="request()->routeIs('theatres.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-building text-gray-500 w-5 text-center"></i>
                        Theatres
                    </div>
                </x-nav-link>
            </li>


            <li>
                <x-nav-link :href="route('screens.index')" :active="request()->routeIs('screens.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-tv text-gray-500 w-5 text-center"></i>
                        Screens
                    </div>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link :href="route('shows.index')" :active="request()->routeIs('shows.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-calendar-event text-gray-500 w-5 text-center"></i>
                        Shows
                    </div>
                </x-nav-link>
            </li>

            <!-- <li>
                <x-nav-link href="#" :active="request()->routeIs('seats.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-box2 text-gray-500 w-5 text-center"></i>
                        Seats
                    </div>
                </x-nav-link>
            </li> -->


            <li>
                <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-journal-bookmark text-gray-500 w-5 text-center"></i>
                        Bookings
                    </div>
                </x-nav-link>
            </li>
            @can('view users')
            <li>
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-people text-gray-500 w-5 text-center"></i>
                        Users
                    </div>
                </x-nav-link>
            </li>
            @endcan
            @if(auth()->user()->hasRole('Admin'))
            <li>
                <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-gear text-gray-500 w-5 text-center"></i>
                        Setting
                    </div>
                </x-nav-link>
            </li>
            @endif
        </ul>



    </nav>

    <!-- Footer -->
    <div class="p-3 border-t border-gray-100 text-center text-xs text-gray-400">
        © {{ date('Y') }} MovieBook
    </div>
</aside>