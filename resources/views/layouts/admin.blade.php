<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — PLN ULP Wangon</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col overflow-hidden w-full">
        {{-- Top Header --}}
        <header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-4 lg:px-8">
            <div class="flex items-center">
                <button @click="$dispatch('toggle-sidebar')" class="lg:hidden text-gray-600 hover:text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="font-semibold text-lg text-gray-800">@yield('title')</h1>
            </div>
            
            <div class="flex items-center relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-700 transition">
                    <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                    <span class="text-sm font-medium hidden sm:block">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="open" @click.outside="open = false" class="absolute right-0 top-10 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50" style="display: none;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 lg:px-8 pt-4">
            @include('layouts.partials.flash-messages')
        </div>

        {{-- Scrollable Main Content --}}
        <main class="flex-1 overflow-y-auto p-4 lg:p-8 relative">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
