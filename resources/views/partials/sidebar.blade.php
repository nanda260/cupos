<aside id="cupos-sidebar" class="cupos-sidebar flex-shrink-0 flex flex-col p-6 cupos-sidebar-text-100">

    {{-- Logo --}}
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center gap-2">
            <div class="cupos-logo-mark w-9 h-9 rounded-xl flex items-center justify-center overflow-hidden">
                @if ($shopProfile?->logo)
                    <img src="{{ Storage::url($shopProfile->logo) }}" alt="{{ $shopProfile->name }}" class="w-full h-full object-cover">
                @else
                    <span class="cupos-logo-pie w-4 h-4 rounded-full"></span>
                @endif
            </div>
            <span class="font-display font-bold text-lg truncate max-w-[10rem]">{{ $shopProfile->name ?? 'CUPOS' }}</span>
        </div>
        <button type="button" onclick="toggleSidebar()" class="cupos-mobile-only cupos-sidebar-icon-btn transition">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    {{--
        Daftar menu didefinisikan sebagai array asosiatif agar navigasi
        mudah ditambah/diubah tanpa menyalin blok <a> berulang kali
        (prinsip DRY). Setiap item: label, route name, dan path ikon SVG.
    --}}
    @php
        $menuItems = [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
            ],
            [
                'label' => 'Transaksi',
                'route' => 'transactions.index',
                'icon'  => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
            ],
            [
                'label'    => 'Data Produk',
                'type'     => 'dropdown',
                'icon'     => '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8z"/><path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/>',
                'children' => [
                    [
                        'label' => 'Kategori',
                        'route' => 'categories.index',
                        'icon'  => '<path d="M20.59 13.41L11 3.83A2 2 0 0 0 9.59 3.17L4 3a1 1 0 0 0-1 1l.17 5.59a2 2 0 0 0 .66 1.41l9.58 9.58a2 2 0 0 0 2.83 0l4.35-4.35a2 2 0 0 0 0-2.83z"/><circle cx="7.5" cy="7.5" r="1.5"/>',
                    ],
                    [
                        'label' => 'Varian',
                        'route' => 'modifier-groups.index',
                        'icon'  => '<path d="M4 21v-7"/><path d="M4 10V3"/><path d="M12 21v-9"/><path d="M12 8V3"/><path d="M20 21v-5"/><path d="M20 12V3"/><path d="M1 14h6"/><path d="M9 8h6"/><path d="M17 16h6"/>',
                    ],
                    [
                        'label' => 'Produk',
                        'route' => 'products.index',
                        'icon'  => '<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8z"/><path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/>',
                    ],
                ],
            ],
            [
                'label' => 'Laporan',
                'route' => 'reports.index',
                'icon'  => '<path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/>',
            ],
            [
                'label'    => 'Pengaturan',
                'type'     => 'dropdown',
                'icon'     => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
                'children' => [
                    [
                        'label' => 'Profil Kedai',
                        'route' => 'settings.index',
                        'icon'  => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
                    ],
                    [
                        'label' => 'Personalisasi',
                        'route' => 'settings.personalization',
                        'icon'  => '<circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.062 0-.874.716-1.625 1.625-1.625H16c3.312 0 6-2.688 6-6 0-4.5-4.5-8.5-10-8.5z"/>',
                    ],
                ],
            ],
        ];
    @endphp

    <nav class="flex-1 flex flex-col gap-1.5">
        @foreach ($menuItems as $item)
            @if (($item['type'] ?? 'link') === 'dropdown')
                @php
                    // Dropdown dianggap aktif jika salah satu route anaknya
                    // sedang dibuka, sehingga otomatis terbuka saat halaman dimuat.
                    $hasActiveChild = collect($item['children'])->contains(
                        fn ($child) => \Illuminate\Support\Facades\Route::has($child['route'])
                            && request()->routeIs($child['route'])
                    );
                @endphp
                <details class="cupos-sidebar-dropdown group" {{ $hasActiveChild ? 'open' : '' }}>
                    <summary class="cupos-sidebar-link flex items-center justify-between gap-3 rounded-xl px-4 py-3 text-sm cursor-pointer list-none marker:hidden {{ $hasActiveChild ? 'is-active' : '' }}">
                        <span class="flex items-center gap-3">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                {!! $item['icon'] !!}
                            </svg>
                            {{ $item['label'] }}
                        </span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="transition-transform duration-200 group-open:rotate-180">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </summary>
                    <div class="flex flex-col gap-1 mt-1 pl-9">
                        @foreach ($item['children'] as $child)
                            @php
                                $isChildActive = \Illuminate\Support\Facades\Route::has($child['route'])
                                    && request()->routeIs($child['route']);

                                $childUrl = \Illuminate\Support\Facades\Route::has($child['route'])
                                    ? route($child['route'])
                                    : '#';
                            @endphp
                            <a href="{{ $childUrl }}"
                               onclick="if (window.innerWidth < 768) toggleSidebar()"
                               class="cupos-sidebar-link flex items-center gap-3 rounded-xl px-3 py-2 text-sm {{ $isChildActive ? 'is-active' : '' }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    {!! $child['icon'] !!}
                                </svg>
                                {{ $child['label'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @else
                @php
                    // Route yang belum didaftarkan (misal 'transactions.index'
                    // belum dibuat) akan dianggap tidak aktif, bukan error,
                    // agar sidebar tetap tampil normal saat halaman lain
                    // belum selesai dikembangkan.
                    $isActive = \Illuminate\Support\Facades\Route::has($item['route'])
                        && request()->routeIs($item['route']);

                    $targetUrl = \Illuminate\Support\Facades\Route::has($item['route'])
                        ? route($item['route'])
                        : '#';
                @endphp
                <a href="{{ $targetUrl }}"
                   onclick="if (window.innerWidth < 768) toggleSidebar()"
                   class="cupos-sidebar-link flex items-center gap-3 rounded-xl px-4 py-3 text-sm {{ $isActive ? 'is-active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </nav>

    {{-- Info User & Logout --}}
    <div class="cupos-sidebar-border border-t pt-5 mt-5">
        <p class="text-sm font-medium cupos-sidebar-text-100 truncate">{{ auth()->user()->name }}</p>
        <p class="text-xs cupos-sidebar-text-40 truncate mb-4">{{ auth()->user()->email }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-2 text-sm cupos-sidebar-icon-btn transition" style="cursor: pointer;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                Keluar
            </button>
        </form>

        <p class="text-[10px] cupos-sidebar-text-25 text-center mt-4">Powered by CUPOS</p>
    </div>
</aside>