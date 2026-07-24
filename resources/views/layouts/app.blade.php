<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title ?? ($shopProfile->name ?? 'CUPOS'))</title>

    @if (isset($shopProfile) && $shopProfile?->logo)
        <link rel="icon" type="image/png" href="{{ Storage::url($shopProfile->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="cupos-page-bg min-h-screen">

    <div class="flex min-h-screen relative">

        {{-- Sidebar diekstrak sebagai partial agar bisa dipakai ulang
             di semua halaman yang memerlukan navigasi (transaksi,
             produk, laporan, dll) tanpa duplikasi markup. --}}
        @include('partials.sidebar')

        {{-- Backdrop, hanya tampil saat sidebar dibuka di mobile --}}
        <div id="cupos-sidebar-backdrop" onclick="toggleSidebar()" class="cupos-sidebar-backdrop"></div>

        {{-- KONTEN UTAMA --}}
        <main class="flex-1 p-6 sm:p-10">
            {{-- Tombol buka menu, hanya tampil di mobile --}}
            <button type="button" onclick="toggleSidebar()" class="cupos-mobile-only mb-4 inline-flex items-center gap-2 text-gray-700 bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm shadow-sm">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                Menu
            </button>
            {{-- Header halaman: judul & subjudul disuplai tiap view lewat @section --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="font-display text-2xl font-bold text-gray-900">
                        @yield('page-title')
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        @yield('page-subtitle')
                    </p>
                </div>
            </div>

            {{-- Slot konten utama tiap halaman --}}
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('cupos-sidebar').classList.toggle('is-open');
            document.getElementById('cupos-sidebar-backdrop').classList.toggle('is-open');
        }
    </script>
</body>
</html>