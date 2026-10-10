{{-- Footer --}}
<footer class="bg-gray-800 text-gray-400 py-8 mt-auto">
    <div class="container mx-auto px-4 text-center">
        <p class="text-sm">
            &copy; {{ date('Y') }} PT. PLN (Persero) ULP Wangon — Sistem Pendaftaran Magang.
        </p>
        <p class="text-xs mt-2 text-gray-500">
            Dibangun dengan Laravel {{ app()->version() }}
        </p>
    </div>
</footer>
