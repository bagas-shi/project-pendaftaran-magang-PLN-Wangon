<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Pendaftaran dan Penerimaan Magang / Kerja Praktek PT. PLN (Persero) ULP Wangon">

    <title>@yield('title', 'Sistem Magang') — PLN ULP Wangon</title>

    {{-- Tailwind CSS 4.x via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for UI interactivity (Dropdowns, Mobile Menu) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    {{-- Additional page-specific styles --}}
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased flex flex-col">

    {{-- Navigation --}}
    @include('layouts.partials.navbar')

    {{-- Flash Messages --}}
    @include('layouts.partials.flash-messages')

    {{-- Main Content --}}
    <main class="container mx-auto px-4 py-8 flex-grow w-full">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Additional page-specific scripts --}}
    @stack('scripts')
</body>
</html>
