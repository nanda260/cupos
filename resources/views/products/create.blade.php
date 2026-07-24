@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'Lengkapi data produk dan pilih modifier yang tersedia.')

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="cupos-stat-card rounded-2xl p-6 max-w-2xl">
        @csrf
        @include('products._form')
        <button type="submit" class="cupos-btn-primary rounded-xl px-6 py-2.5 text-sm font-semibold text-gray-900 mt-6">
            Simpan Produk
        </button>
    </form>
@endsection