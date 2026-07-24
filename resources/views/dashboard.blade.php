@extends('layouts.app')

@section('title', 'Dashboard - ' . ($shopProfile->name ?? 'CUPOS'))
@section('page-title', 'Selamat Datang, ' . $user->name)
@section('page-subtitle', 'Berikut ringkasan aktivitas toko Anda hari ini.')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        <div class="cupos-stat-card rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Penjualan Hari Ini</p>
            <p class="font-display text-2xl font-bold text-gray-900">Rp 0</p>
        </div>

        <div class="cupos-stat-card rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Transaksi Hari Ini</p>
            <p class="font-display text-2xl font-bold text-gray-900">0</p>
        </div>

        <div class="cupos-stat-card rounded-2xl p-6">
            <p class="text-sm text-gray-500 mb-1">Produk Terjual</p>
            <p class="font-display text-2xl font-bold text-gray-900">0</p>
        </div>
    </div>
@endsection