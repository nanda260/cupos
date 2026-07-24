<?php

namespace App\Http\Controllers;

use App\Models\ModifierGroup;
use App\Models\ModifierOption;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ModifierOptionController extends Controller
{
    public function store(Request $request, ModifierGroup $modifierGroup): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'extra_price' => ['required', 'numeric', 'min:0'],
        ]);

        $modifierGroup->options()->create($validated);

        return back()->with('success', 'Opsi modifier berhasil ditambahkan.');
    }

    public function update(Request $request, ModifierOption $modifierOption): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'extra_price' => ['required', 'numeric', 'min:0'],
        ]);

        $modifierOption->update($validated);

        return back()->with('success', 'Opsi modifier berhasil diperbarui.');
    }

    public function destroy(ModifierOption $modifierOption): RedirectResponse
    {
        $modifierOption->delete();

        return back()->with('success', 'Opsi modifier berhasil dihapus.');
    }
}