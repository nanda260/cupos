<?php

namespace App\Http\Controllers;

use App\Models\ModifierGroup;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ModifierGroupController extends Controller
{
    public function index(): View
    {
        $modifierGroups = ModifierGroup::with('options')->orderBy('name')->get();

        return view('modifier-groups.index', compact('modifierGroups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'selection_type' => ['required', 'in:single,multiple'],
            'is_required' => ['nullable', 'boolean'],
        ]);

        $validated['is_required'] = $request->boolean('is_required');

        ModifierGroup::create($validated);

        return back()->with('success', 'Grup modifier berhasil ditambahkan.');
    }

    public function update(Request $request, ModifierGroup $modifierGroup): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'selection_type' => ['required', 'in:single,multiple'],
            'is_required' => ['nullable', 'boolean'],
        ]);

        $validated['is_required'] = $request->boolean('is_required');

        $modifierGroup->update($validated);

        return back()->with('success', 'Grup modifier berhasil diperbarui.');
    }

    public function destroy(ModifierGroup $modifierGroup): RedirectResponse
    {
        $modifierGroup->delete();

        return back()->with('success', 'Grup modifier berhasil dihapus.');
    }
}