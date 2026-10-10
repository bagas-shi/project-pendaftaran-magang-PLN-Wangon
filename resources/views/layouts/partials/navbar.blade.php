{{-- Navigation Bar --}}
<nav class="bg-white shadow-sm border-b border-gray-200" id="main-navbar">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img src="{{ asset('assets/Logo_PLN.png') }}" width="30" height="30" alt="Logo PLN">
                <span class="text-sm font-bold text-blue-500 hidden sm:inline">ULP Wangon</span>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-700 transition"
                        id="nav-login">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
                        id="nav-register">Daftar</a>
                @else
                    {{-- Role-specific navigation --}}
                    @role('peserta')
                    <a href="{{ route('peserta.dashboard') }}"
                        class="text-gray-600 hover:text-blue-700 transition">Dashboard</a>
                    @if(!Auth::user()->pendaftaran()->where('status', 'diterima')->exists())
                        <a href="{{ route('peserta.pendaftaran.create') }}"
                            class="text-gray-600 hover:text-blue-700 transition">Daftar Magang</a>
                    @endif
                    @endrole

                    @role('admin|super_admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-700 transition">Dashboard
                        Admin</a>
                    <a href="{{ route('admin.pendaftaran.index') }}"
                        class="text-gray-600 hover:text-blue-700 transition">Pendaftaran</a>
                    @endrole

                    @role('super_admin')
                    <a href="{{ route('superadmin.admins.index') }}"
                        class="text-gray-600 hover:text-blue-700 transition">Kelola Admin</a>
                    @endrole

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 text-gray-700 hover:text-blue-700 transition"
                            id="user-dropdown-btn">
                            <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover">
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"
                                    id="nav-logout">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile hamburger --}}
            <button class="md:hidden text-gray-600" id="mobile-menu-btn"
                @click="$refs.mobileMenu.classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div class="hidden md:hidden pb-4" x-ref="mobileMenu" id="mobile-menu">
            @guest
                <a href="{{ route('login') }}" class="block py-2 text-gray-600 hover:text-blue-700">Masuk</a>
                <a href="{{ route('register') }}" class="block py-2 text-gray-600 hover:text-blue-700">Daftar</a>
            @else
                @role('peserta')
                <a href="{{ route('peserta.dashboard') }}"
                    class="block py-2 text-gray-600 hover:text-blue-700">Dashboard</a>
                @endrole
                @role('admin|super_admin')
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-600 hover:text-blue-700">Dashboard
                    Admin</a>
                @endrole
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left py-2 text-red-600 hover:text-red-700">Keluar</button>
                </form>
            @endguest
        </div>
    </div>
</nav>