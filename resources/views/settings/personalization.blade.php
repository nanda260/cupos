@extends('layouts.app')

@section('title', 'Personalisasi - ' . ($shopProfile->name ?? 'CUPOS'))
@section('page-title', 'Personalisasi')
@section('page-subtitle', 'Sesuaikan warna tampilan aplikasi agar sesuai identitas kedai Anda.')

@section('content')
    <div class="max-w-3xl">

        @if (session('status'))
            <div
                class="mb-6 flex items-center gap-2 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    class="flex-shrink-0">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('settings.personalization.update') }}" id="personalization-form"
            class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Kartu: Pemilih Warna --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="13.5" cy="6.5" r=".5" />
                            <circle cx="17.5" cy="10.5" r=".5" />
                            <circle cx="8.5" cy="7.5" r=".5" />
                            <circle cx="6.5" cy="12.5" r=".5" />
                            <path
                                d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.062 0-.874.716-1.625 1.625-1.625H16c3.312 0 6-2.688 6-6 0-4.5-4.5-8.5-10-8.5z" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Warna Tema</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Warna Aksen Utama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Aksen Utama</label>
                        <p class="text-xs text-gray-400 mb-3">Dipakai pada tombol, menu aktif, dan focus ring.</p>

                        <div class="flex items-center gap-3">
                            <input type="color" id="primary_color_picker"
                                value="{{ old('primary_color', $shopProfile->primary_color ?? '#EF9F2E') }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-0.5 bg-white">
                            <input type="text" name="primary_color" id="primary_color_text"
                                value="{{ old('primary_color', $shopProfile->primary_color ?? '#EF9F2E') }}" maxlength="7"
                                placeholder="#EF9F2E"
                                class="cupos-input flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-mono uppercase transition">
                        </div>
                        @error('primary_color')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror

                        {{-- Preset cepat agar mahasiswa/pengguna tak perlu tahu kode hex --}}
                        <div class="flex gap-2 mt-3">
                            @foreach (['#EF9F2E', '#3B82F6', '#10B981', '#EF4444', '#8B5CF6', '#EC4899'] as $preset)
                                <button type="button"
                                    class="cupos-color-preset w-6 h-6 rounded-full border border-gray-200"
                                    style="background-color: {{ $preset }};" data-target="primary_color"
                                    data-value="{{ $preset }}" aria-label="Pilih warna {{ $preset }}"></button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Warna Sidebar --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Dasar Sidebar</label>
                        <p class="text-xs text-gray-400 mb-3">Warna dasar panel navigasi & halaman login. Gradasi
                            terang/gelap dibuat otomatis dari warna ini.</p>

                        <div class="flex items-center gap-3">
                            <input type="color" id="sidebar_color_picker"
                                value="{{ old('sidebar_color', $shopProfile->sidebar_color ?? '#1C1710') }}"
                                class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-0.5 bg-white">
                            <input type="text" name="sidebar_color" id="sidebar_color_text"
                                value="{{ old('sidebar_color', $shopProfile->sidebar_color ?? '#1C1710') }}" maxlength="7"
                                placeholder="#1C1710"
                                class="cupos-input flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-mono uppercase transition">
                        </div>
                        @error('sidebar_color')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror

                        <div class="flex gap-2 mt-3">
                            @foreach (['#1C1710', '#0F172A', '#1E293B', '#292524', '#18181B', '#16A34A', '#0369A1'] as $preset)
                                <button type="button"
                                    class="cupos-color-preset w-6 h-6 rounded-full border border-gray-200"
                                    style="background-color: {{ $preset }};" data-target="sidebar_color"
                                    data-value="{{ $preset }}"
                                    aria-label="Pilih warna {{ $preset }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{--
                    Mode teks sidebar dipisah dari pemilihan warna karena
                    keduanya independen: warna sidebar bisa apa saja,
                    tapi kontras teks perlu diatur manual oleh user —
                    kita tidak menghitung kontras otomatis agar user
                    tetap punya kendali penuh (predictable behavior).
                --}}
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Warna Teks Sidebar</label>
                    <p class="text-xs text-gray-400 mb-3">Pilih "Gelap" jika warna sidebar Anda terang, agar teks menu tetap
                        terbaca.</p>

                    <div class="flex gap-3">
                        <label
                            class="cupos-text-mode-option flex-1 flex items-center gap-2 rounded-xl border border-gray-300 px-4 py-2.5 text-sm cursor-pointer">
                            <input type="radio" name="sidebar_text_mode" value="light" id="text_mode_light"
                                {{ old('sidebar_text_mode', $shopProfile->sidebar_text_mode ?? 'light') === 'light' ? 'checked' : '' }}>
                            <span class="w-4 h-4 rounded-full bg-white border border-gray-300"></span>
                            Terang (putih)
                        </label>
                        <label
                            class="cupos-text-mode-option flex-1 flex items-center gap-2 rounded-xl border border-gray-300 px-4 py-2.5 text-sm cursor-pointer">
                            <input type="radio" name="sidebar_text_mode" value="dark" id="text_mode_dark"
                                {{ old('sidebar_text_mode', $shopProfile->sidebar_text_mode ?? 'light') === 'dark' ? 'checked' : '' }}>
                            <span class="w-4 h-4 rounded-full bg-gray-900 border border-gray-300"></span>
                            Gelap (hitam)
                        </label>
                    </div>
@error('sidebar_text_mode')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
                </div>
            </div>

            {{-- Kartu: Latar Belakang Halaman --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" />
                            <path d="M3 9h18" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Latar Belakang Halaman</h2>
                </div>

                <label class="block text-sm font-medium text-gray-700 mb-2">Warna Latar Utama</label>
                <p class="text-xs text-gray-400 mb-3">Warna area di luar kartu putih — berlaku di seluruh halaman admin dan halaman login.</p>

                <div class="flex items-center gap-3">
                    <input type="color" id="body_color_picker"
                        value="{{ old('body_color', $shopProfile->body_color ?? '#DAD4C6') }}"
                        class="w-12 h-12 rounded-lg border border-gray-300 cursor-pointer p-0.5 bg-white">
                    <input type="text" name="body_color" id="body_color_text"
                        value="{{ old('body_color', $shopProfile->body_color ?? '#DAD4C6') }}"
                        maxlength="7" placeholder="#DAD4C6"
                        class="cupos-input flex-1 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-mono uppercase transition">
                </div>
                @error('body_color')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror

                <div class="flex gap-2 mt-3">
                    @foreach (['#DAD4C6', '#F1F5F9', '#E7E5E4', '#FDE9D9', '#E2E8F0'] as $preset)
                        <button type="button"
                            class="cupos-color-preset w-6 h-6 rounded-full border border-gray-200"
                            style="background-color: {{ $preset }};" data-target="body_color"
                            data-value="{{ $preset }}" aria-label="Pilih warna {{ $preset }}"></button>
                    @endforeach
                </div>
            </div>

            {{-- Kartu: Pratinjau Langsung --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <h2 class="font-display font-semibold text-gray-900 mb-4">Pratinjau</h2>
                <p class="text-xs text-gray-400 mb-4">Perubahan di bawah ini bersifat langsung (belum tersimpan). Klik
                    "Simpan" untuk menerapkannya ke seluruh aplikasi.</p>

                <div id="preview-sidebar-item"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold mb-4"
                    style="background: {{ $shopProfile->primary_color ?? '#EF9F2E' }}; color: #14161c;">
                    Menu Aktif (contoh)
                </div>
                <br>
                <button type="button" id="preview-button"
                    class="inline-flex items-center gap-2 rounded-xl px-7 py-2.5 text-sm font-semibold text-gray-900"
                    style="background: {{ $shopProfile->primary_color ?? '#EF9F2E' }};">
                    Tombol Aksi (contoh)
                </button>

                {{-- Pratinjau mini sidebar, agar user tak perlu buka menu
                     asli untuk melihat efek warna + mode teks. --}}
                <div id="preview-sidebar-block" class="mt-5 rounded-xl p-4 w-56"
                    style="background: {{ $shopProfile->sidebar_color ?? '#1C1710' }};">
                    <p id="preview-sidebar-text" class="text-sm font-semibold mb-1"
                        style="color: {{ ($shopProfile->sidebar_text_mode ?? 'light') === 'dark' ? '#14161c' : '#ffffff' }};">
                        Nama Menu
                    </p>
                    <p id="preview-sidebar-subtext" class="text-xs"
                        style="color: {{ ($shopProfile->sidebar_text_mode ?? 'light') === 'dark' ? 'rgba(20,22,28,0.6)' : 'rgba(255,255,255,0.6)' }};">
                        Sub menu contoh
                    </p>
                </div>

                {{-- Pratinjau latar halaman: kartu kecil "mengambang"
                     di atas warna latar, meniru tampilan kartu putih
                     di atas cupos-page-bg pada halaman sesungguhnya. --}}
                <div id="preview-body-block" class="mt-5 rounded-xl p-5 w-56"
                    style="background: {{ $shopProfile->body_color ?? '#DAD4C6' }};">
                    <div class="rounded-lg bg-white p-3 text-xs text-gray-500 shadow-sm">
                        Contoh kartu di atas latar
                    </div>
                </div>
            </div>

            {{-- Aksi --}}
            <div class="flex justify-end pt-1">
                <button type="submit"
                    class="cupos-btn-primary inline-flex items-center gap-2 rounded-xl px-7 py-2.5 text-sm font-semibold text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    <span>Simpan Tema</span>
                </button>
            </div>
        </form>
    </div>

    <style>
        .cupos-text-mode-option:has(input:checked) {
            border-color: var(--cupos-primary, #EF9F2E);
            background-color: rgba(var(--cupos-primary-rgb, 239, 159, 46), 0.06);
        }
    </style>

    <script>
        function bindColorSync(pickerId, textId, onChange) {
            const picker = document.getElementById(pickerId);
            const text = document.getElementById(textId);

            picker.addEventListener('input', () => {
                text.value = picker.value.toUpperCase();
                onChange(picker.value);
            });

            text.addEventListener('input', () => {
                const value = text.value.trim();
                if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                    picker.value = value;
                    onChange(value);
                }
            });
        }

        const previewButton = document.getElementById('preview-button');
        const previewSidebarItem = document.getElementById('preview-sidebar-item');

        bindColorSync('primary_color_picker', 'primary_color_text', (color) => {
            previewButton.style.background = color;
            previewSidebarItem.style.background = color;
        });

        const previewSidebarBlock = document.getElementById('preview-sidebar-block');

        bindColorSync('sidebar_color_picker', 'sidebar_color_text', (color) => {
            previewSidebarBlock.style.background = color;
        });

        const previewBodyBlock = document.getElementById('preview-body-block');

        bindColorSync('body_color_picker', 'body_color_text', (color) => {
            previewBodyBlock.style.background = color;
        });

        // Live preview untuk mode teks: langsung ganti warna teks
        // pratinjau saat radio button diklik, tanpa perlu submit dulu.
        function applyTextMode(mode) {
            const textColor = mode === 'dark' ? '#14161c' : '#ffffff';
            const subTextColor = mode === 'dark' ? 'rgba(20,22,28,0.6)' : 'rgba(255,255,255,0.6)';
            document.getElementById('preview-sidebar-text').style.color = textColor;
            document.getElementById('preview-sidebar-subtext').style.color = subTextColor;
        }

        document.querySelectorAll('input[name="sidebar_text_mode"]').forEach((radio) => {
            radio.addEventListener('change', () => applyTextMode(radio.value));
        });

        document.querySelectorAll('.cupos-color-preset').forEach((btn) => {
            btn.addEventListener('click', () => {
                const target = btn.dataset.target; // 'primary_color' | 'sidebar_color' | 'body_color'
                const value = btn.dataset.value;
                document.getElementById(`${target}_picker`).value = value;
                document.getElementById(`${target}_text`).value = value.toUpperCase();
                document.getElementById(`${target}_picker`).dispatchEvent(new Event('input'));
            });
        });
    </script>
@endsection
