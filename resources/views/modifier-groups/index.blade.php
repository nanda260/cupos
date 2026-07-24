@extends('layouts.app')

@section('title', 'Varian & Modifier')
@section('page-title', 'Varian & Modifier')
@section('page-subtitle', 'Kelola opsi tambahan seperti Sugar Level, Ice Level, Milk Options, Extra Shot, dan Add-ons.')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="cupos-stat-card rounded-2xl p-6 mb-6">
        <h2 class="font-display text-lg font-bold text-gray-900 mb-4">Tambah Grup Modifier</h2>
        <form action="{{ route('modifier-groups.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 sm:items-center">
            @csrf
            <input type="text" name="name" placeholder="Nama grup (mis. Sugar Level)" value="{{ old('name') }}"
                class="cupos-input flex-1 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
            <select name="selection_type" class="cupos-input rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
                <option value="single">Hanya boleh pilih 1</option>
                <option value="multiple">Boleh lebih dari 1 (Add-ons)</option>
            </select>
            <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="is_required" value="1" class="rounded border-gray-300">
                Wajib dipilih
            </label>
            <button type="submit" class="cupos-btn-primary inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Simpan
            </button>
        </form>
        @error('name') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-5">
        @forelse ($modifierGroups as $group)
            <div class="cupos-stat-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-display font-bold text-gray-900">{{ $group->name }}</h3>
                        <p class="text-xs text-gray-400">
                            {{ $group->selection_type === 'single' ? 'Pilih 1 opsi' : 'Boleh pilih lebih dari 1' }}
                            @if ($group->is_required) &middot; Wajib dipilih @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            onclick="openGroupEditModal('{{ $group->id }}', '{{ addslashes($group->name) }}', '{{ $group->selection_type }}', {{ $group->is_required ? 'true' : 'false' }}, '{{ route('modifier-groups.update', $group) }}')"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition-colors"
                            title="Edit grup">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path></svg>
                        </button>
                        <form action="{{ route('modifier-groups.destroy', $group) }}" method="POST"
                            onsubmit="return confirm('Hapus grup {{ $group->name }} beserta semua opsinya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                title="Hapus grup">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="divide-y divide-gray-100 mb-4">
                    @forelse ($group->options as $option)
                        <div class="flex items-center justify-between py-2 text-sm">
                            <span class="text-gray-700">{{ $option->name }}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-gray-400">+Rp {{ number_format($option->extra_price, 0, ',', '.') }}</span>
                                <form action="{{ route('modifier-options.destroy', $option) }}" method="POST"
                                    onsubmit="return confirm('Hapus opsi {{ $option->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors"
                                        title="Hapus opsi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 py-2">Belum ada opsi.</p>
                    @endforelse
                </div>

                <form action="{{ route('modifier-options.store', $group) }}" method="POST" class="flex gap-3">
                    @csrf
                    <input type="text" name="name" placeholder="Nama opsi (mis. Less Sugar)"
                        class="cupos-input flex-1 rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none">
                    <input type="number" step="0.01" min="0" name="extra_price" placeholder="Rp 0" value="0"
                        class="cupos-input w-32 rounded-xl border border-gray-200 px-4 py-2 text-sm focus:outline-none">
                    <button type="submit" class="cupos-btn-primary inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Opsi
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-400 text-sm">Belum ada grup modifier.</p>
        @endforelse
    </div>

    {{-- Modal Edit Grup Modifier --}}
    <div id="group-edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4" onclick="if (event.target === this) closeGroupEditModal();">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6" onclick="event.stopPropagation();">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-display text-lg font-bold text-gray-900">Edit Grup Modifier</h3>
                <button type="button" onclick="closeGroupEditModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <form id="group-edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Nama Grup</label>
                    <input type="text" name="name" id="group-edit-name"
                        class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Tipe Pilihan</label>
                    <select name="selection_type" id="group-edit-selection-type"
                        class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
                        <option value="single">Hanya boleh pilih 1</option>
                        <option value="multiple">Boleh lebih dari 1 (Add-ons)</option>
                    </select>
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 mb-6">
                    <input type="checkbox" name="is_required" id="group-edit-is-required" value="1" class="rounded border-gray-300">
                    Wajib dipilih
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeGroupEditModal()"
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
        function openGroupEditModal(id, name, selectionType, isRequired, actionUrl) {
            document.getElementById('group-edit-form').action = actionUrl;
            document.getElementById('group-edit-name').value = name;
            document.getElementById('group-edit-selection-type').value = selectionType;
            document.getElementById('group-edit-is-required').checked = isRequired;
            const modal = document.getElementById('group-edit-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeGroupEditModal() {
            const modal = document.getElementById('group-edit-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
@endsection