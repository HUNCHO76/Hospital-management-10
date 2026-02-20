<nav class="bg-white border-b border-gray-200 px-4 sm:px-6 py-3 shadow-sm sticky top-0 z-10">
    <div class="flex justify-between items-center">
        <!-- Left side: Logo and mobile menu button -->
        <div class="flex items-center gap-4">
            <!-- Mobile menu toggle (hamburger) - visible only on mobile -->
            <button type="button" id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Hospital Management</h1>
        </div>

        <!-- Right side: Notifications, Settings, User -->
        <div class="flex items-center gap-3 sm:gap-6">
            <!-- Notifications dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="relative text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <!-- Notification badge (example with 3 unread) -->
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                </button>
                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg border border-gray-200 z-20" style="display: none;">
                    <div class="p-3 border-b border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <!-- Example notification items -->
                        <a href="#" class="flex items-start gap-3 p-3 hover:bg-gray-50 transition">
                            <div class="bg-blue-100 rounded-full p-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">New patient admitted</p>
                                <p class="text-xs text-gray-500">5 minutes ago</p>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 p-3 hover:bg-gray-50 transition">
                            <div class="bg-green-100 rounded-full p-2">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Appointment reminder</p>
                                <p class="text-xs text-gray-500">1 hour ago</p>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-t border-gray-200 text-center">
                        <a href="#" class="text-sm text-blue-600 hover:underline">See all notifications</a>
                    </div>
                </div>
            </div>

            <!-- Settings icon -->
            <a href="#" class="text-gray-600 hover:text-gray-900 hidden sm:block">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </a>

            <!-- User menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->FirstName ?? Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->role ?? 'User' }}</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-gray-700 font-semibold uppercase">
                        {{ substr(Auth::user()->FirstName ?? Auth::user()->name, 0, 1) }}
                    </div>
                </button>
                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200 z-20" style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Simple script to toggle sidebar on mobile -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.lg\\:col-span-1'); // Sidebar container

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('max-lg:hidden');
            });
        }
    });
</script>