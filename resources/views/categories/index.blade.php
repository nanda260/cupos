@extends('layouts.app')

@section('title', 'Kategori Produk')
@section('page-title', 'Kategori Produk')
@section('page-subtitle', 'Kelola kategori seperti Coffee, Non-Coffee, Pastry, dan Mixology.')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">{{ session('error') }}</div>
    @endif

    <div class="cupos-stat-card rounded-2xl p-6 mb-6">
        <h2 class="font-display text-lg font-bold text-gray-900 mb-4">Tambah Kategori</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 sm:items-center">
            @csrf
            <input type="text" name="name" placeholder="Nama kategori" value="{{ old('name') }}"
                class="cupos-input flex-1 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300">
                Aktif
            </label>
            <button type="submit" class="cupos-btn-primary inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Simpan
            </button>
        </form>
        @error('name')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div class="cupos-stat-card rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-left">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Jumlah Produk</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <tr class="hover:bg-gray-50/60 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $category->products_count }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full {{ $category->is_active ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <button type="button"
                                    onclick="openEditModal('{{ $category->id }}', '{{ addslashes($category->name) }}', {{ $category->is_active ? 'true' : 'false' }}, '{{ route('categories.update', $category) }}')"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors"
                                    title="Edit kategori">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>
                                </button>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Hapus kategori {{ $category->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                        title="Hapus kategori">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Edit Kategori --}}
    <div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4" onclick="if (event.target === this) closeEditModal();">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" onclick="event.stopPropagation();">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-lg font-bold text-gray-900">Edit Kategori</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Nama Kategori</label>
                    <input type="text" name="name" id="edit-name"
                        class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 mb-6">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" class="rounded border-gray-300">
                    Aktif
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-500 hover:bg-gray-100">
                        Batal
                    </button>
                    <button type="submit"
                        class="cupos-btn-primary rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-900">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, isActive, actionUrl) {
            document.getElementById('edit-form').action = actionUrl;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-is-active').checked = isActive;
            const modal = document.getElementById('edit-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection