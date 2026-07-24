@extends('layouts.app')

@section('title', 'Profil Kedai - ' . ($shopProfile->name ?? 'CUPOS'))
@section('page-title', 'Profil Kedai')
@section('page-subtitle', 'Informasi ini akan tampil sebagai identitas kedai dan pada struk cetak.')

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

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Kartu: Identitas Kedai --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M3 21h18M3 7v14M21 7v14M6.5 3h11L21 7H3l3.5-4z" />
                            <path d="M9 12h2M13 12h2M9 16h2M13 16h2" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Identitas Kedai</h2>
                </div>

                <div class="flex flex-col sm:flex-row gap-6">
                    {{-- Logo --}}
                    <div class="flex-shrink-0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                        <label for="logo-input"
                            class="group relative block w-28 h-28 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 hover:border-[#EF9F2E] transition cursor-pointer overflow-hidden">
                            @if ($shopProfile->logo)
                                <img src="{{ Storage::url($shopProfile->logo) }}" alt="Logo"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex flex-col items-center justify-center gap-1 text-gray-400 group-hover:text-[#EF9F2E] transition">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="17 8 12 3 7 8" />
                                        <line x1="12" y1="3" x2="12" y2="15" />
                                    </svg>
                                    <span class="text-[11px] font-medium">Unggah</span>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                                <span
                                    class="opacity-0 group-hover:opacity-100 text-white text-[11px] font-medium transition">Ganti</span>
                            </div>
                        </label>
                        <input id="logo-input" type="file" name="logo" accept="image/*" class="hidden">
                        @error('logo')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kedai</label>
                        <input type="text" name="name" value="{{ old('name', $shopProfile->name) }}"
                            placeholder="Contoh: Kedai Kopi Senja"
                            class="cupos-input w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm transition">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror

                        <label class="block text-sm font-medium text-gray-700 mt-4 mb-2">Nomor HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $shopProfile->phone) }}"
                            placeholder="08xx-xxxx-xxxx"
                            class="cupos-input w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm transition">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Kartu: Alamat --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Alamat</h2>
                </div>

                <textarea name="address" rows="3" placeholder="Tuliskan alamat lengkap kedai"
                    class="cupos-input w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm transition resize-none">{{ old('address', $shopProfile->address) }}</textarea>
                @error('address')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kartu: Kalkulasi Keuangan Dasar --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Kalkulasi Keuangan Dasar</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pajak / PB1 (%)</label>
                        <div class="relative">
                            <input type="number" name="tax_percentage" step="0.01" min="0" max="100"
                                value="{{ old('tax_percentage', $shopProfile->tax_percentage) }}" placeholder="0"
                                class="cupos-input w-full rounded-xl border border-gray-300 pl-4 pr-9 py-2.5 text-sm transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">Pajak restoran (PB1) yang ditambahkan ke total transaksi.
                        </p>
                        @error('tax_percentage')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Service Charge (%)</label>
                        <div class="relative">
                            <input type="number" name="service_charge_percentage" step="0.01" min="0"
                                max="100"
                                value="{{ old('service_charge_percentage', $shopProfile->service_charge_percentage) }}"
                                placeholder="0"
                                class="cupos-input w-full rounded-xl border border-gray-300 pl-4 pr-9 py-2.5 text-sm transition">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">Biaya layanan yang ditambahkan ke total transaksi.</p>
                        @error('service_charge_percentage')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Kartu: Struk --}}
            <div class="cupos-stat-card rounded-2xl p-6 sm:p-7">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-[#EF9F2E]">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path
                                d="M4 2v20l2-1.5L8 22l2-1.5L12 22l2-1.5L16 22l2-1.5L20 22V2l-2 1.5L16 2l-2 1.5L12 2l-2 1.5L8 2 6 3.5 4 2z" />
                            <line x1="8" y1="7" x2="16" y2="7" />
                            <line x1="8" y1="11" x2="16" y2="11" />
                        </svg>
                    </div>
                    <h2 class="font-display font-semibold text-gray-900">Footer Struk</h2>
                </div>

                <textarea name="receipt_footer" rows="2" placeholder="Contoh: Terima kasih telah berbelanja!"
                    class="cupos-input w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm transition resize-none">{{ old('receipt_footer', $shopProfile->receipt_footer) }}</textarea>
                <p class="text-xs text-gray-400 mt-1.5">Teks ini akan tercetak di bagian bawah setiap struk transaksi.</p>
                @error('receipt_footer')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                @enderror
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

                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('logo-input')?.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                const preview = this.closest('div').querySelector('label img, label div.flex-col');
                reader.onload = function(ev) {
                    const label = document.querySelector('label[for="logo-input"]');
                    label.innerHTML = `<img src="${ev.target.result}" alt="Logo" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                        <span class="opacity-0 group-hover:opacity-100 text-white text-[11px] font-medium transition">Ganti</span>
                    </div>`;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endsection
