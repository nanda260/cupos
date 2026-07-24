@php
    $product = $product ?? null;
    $selectedModifierGroups = $selectedModifierGroups ?? [];
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
        <select name="category_id" class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
            class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Dasar (Rp)</label>
        <input type="number" step="0.01" min="0" name="base_price" value="{{ old('base_price', $product->base_price ?? '') }}"
            class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
        @error('base_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1.5">Foto Produk</label>
        <input type="file" name="photo" accept="image/*"
            class="cupos-input w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none">
        @if (! empty($product?->photo_url))
            <img src="{{ $product->photo_url }}" class="w-16 h-16 object-cover rounded-lg mt-2">
        @endif
        @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="sm:col-span-2">
        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }} class="rounded border-gray-300">
            Tersedia untuk dijual
        </label>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">Varian & Modifier</label>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @forelse ($modifierGroups as $group)
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 border border-gray-200 rounded-lg px-3 py-2">
                    <input type="checkbox" name="modifier_groups[]" value="{{ $group->id }}"
                        {{ in_array($group->id, old('modifier_groups', $selectedModifierGroups)) ? 'checked' : '' }}
                        class="rounded border-gray-300">
                    {{ $group->name }}
                    <span class="text-xs text-gray-400">({{ $group->selection_type === 'single' ? 'Pilih 1' : 'Boleh lebih dari 1' }})</span>
                </label>
            @empty
                <p class="text-xs text-gray-400">Belum ada grup modifier. Buat di halaman Varian & Modifier.</p>
            @endforelse
        </div>
    </div>
</div>