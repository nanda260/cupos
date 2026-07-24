<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ModifierGroup;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category')->orderBy('name');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $modifierGroups = ModifierGroup::orderBy('name')->get();

        return view('products.create', compact('categories', 'modifierGroups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('products', 'public');
        }

        $product = Product::create($validated);
        $product->modifierGroups()->sync($request->input('modifier_groups', []));

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $modifierGroups = ModifierGroup::orderBy('name')->get();
        $selectedModifierGroups = $product->modifierGroups()->pluck('modifier_groups.id')->toArray();

        return view('products.edit', compact('product', 'categories', 'modifierGroups', 'selectedModifierGroups'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validated($request, $product->id);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                Storage::disk('public')->delete($product->photo);
            }
            $validated['photo'] = $request->file('photo')->store('products', 'public');
        }

        $product->update($validated);
        $product->modifierGroups()->sync($request->input('modifier_groups', []));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->photo) {
            Storage::disk('public')->delete($product->photo);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function toggleAvailability(Product $product): RedirectResponse
    {
        $product->update(['is_available' => ! $product->is_available]);

        return back()->with('success', 'Status ketersediaan produk diperbarui.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'modifier_groups' => ['nullable', 'array'],
            'modifier_groups.*' => ['exists:modifier_groups,id'],
        ]) + ['is_available' => $request->boolean('is_available', true)];
    }
}