@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', $product->name)

@section('content')
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data"
        class="cupos-stat-card rounded-2xl p-6 max-w-2xl">
        @csrf
        @method('PUT')
        @include('products._form')
        <div class="flex items-center gap-3 mt-6">
            <a href="{{ route('products.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5" />
                    <path d="M12 19l-7-7 7-7" />
                </svg>

                Kembali
            </a>

            <button type="submit"
                class="cupos-btn-primary inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-sm font-semibold text-gray-900">

                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <path d="M17 3h4v4" />
                    <path d="M11 13 21 3" />
                </svg>

                Perbarui Produk
            </button>
        </div>
    </form>
@endsection
