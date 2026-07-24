@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('page-title', 'Katalog Produk')
@section('page-subtitle', 'Kelola produk, harga dasar, dan status ketersediaan.')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('success') }}</div>
    @endif

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">

        <form method="GET" class="flex flex-1 flex-col sm:flex-row gap-3">

            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk..."
                class="cupos-input flex-1 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">

            <select name="category_id"
                class="cupos-input w-full sm:w-56 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">

                <option value="">Semua Kategori</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

            <button type="submit"
                class="cupos-btn-primary inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-900 whitespace-nowrap">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3" />
                </svg>

                Filter
            </button>

        </form>

        <a href="{{ route('products.create') }}"
            class="cupos-btn-primary inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-900 whitespace-nowrap">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>

            Tambah Produk
        </a>

    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($products as $product)
            <div class="cupos-stat-card rounded-2xl overflow-hidden">
                <div class="h-36 bg-gray-100 flex items-center justify-center">
                    @if ($product->photo_url)
                        <img src="{{ $product->photo_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-300 text-xs">Tanpa Foto</span>
                    @endif
                </div>
                <div class="p-5">
                    <p class="text-xs text-amber-600 font-semibold mb-1">{{ $product->category->name }}</p>
                    <h3 class="font-display font-bold text-gray-900 mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">Rp {{ number_format($product->base_price, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between">
                        <form action="{{ route('products.toggle-availability', $product) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="text-xs px-2.5 py-1 rounded-full {{ $product->is_available ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                            </button>
                        </form>
                        <div class="flex gap-3">
                            <a href="{{ route('products.edit', $product) }}"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors"
                                title="Edit Produk">

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                </svg>

                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Hapus produk {{ $product->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                    title="Hapus Produk">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada produk.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
@endsection
