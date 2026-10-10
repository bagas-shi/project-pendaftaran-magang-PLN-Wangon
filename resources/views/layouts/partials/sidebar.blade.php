<aside class="bg-blue-900 text-white w-64 flex-shrink-0 hidden lg:flex flex-col transition-all duration-300"
       x-data="{ showMobile: false }"
       @toggle-sidebar.window="showMobile = !showMobile"
       :class="{ 'fixed inset-y-0 left-0 z-50 flex': showMobile, 'hidden lg:flex': !showMobile }">
    
    <div class="h-16 flex items-center px-6 border-b border-blue-800 bg-blue-950">
        <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white">
            <span class="text-yellow-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
            <span class="text-lg font-bold">PLN ULP Wangon</span>
        </a>
        <button @click="showMobile = false" class="lg:hidden ml-auto text-blue-200 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-4">
        <nav class="space-y-1 px-3">
            @role('admin|super_admin')
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-4 px-3">Admin Panel</div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.pendaftaran.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Pendaftaran
                </a>
            @endrole

            @role('super_admin')
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wider mb-2 mt-6 px-3">Super Admin</div>
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Statistik
                </a>
                <a href="{{ route('superadmin.admins.index') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('superadmin.admins.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola Admin
                </a>
            @endrole
        </nav>
    </div>
    
    <div class="p-4 border-t border-blue-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-3 py-2.5 rounded-lg text-blue-200 hover:bg-red-600 hover:text-white transition">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

{{-- Mobile Overlay --}}
<div x-data="{ showMobile: false }" 
     @toggle-sidebar.window="showMobile = !showMobile"
     x-show="showMobile" 
     @click="showMobile = false"
     class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
     style="display: none;"></div>
