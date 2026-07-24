<?php

namespace App\Http\Controllers;

use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopProfileController extends Controller
{
    /**
     * Profil kedai bersifat singleton (hanya 1 baris data).
     * Jika belum ada baris sama sekali, buatkan default kosong
     * agar form tetap bisa ditampilkan tanpa error.
     */
    public function index()
    {
        $shopProfile = ShopProfile::first() ?? ShopProfile::create([
            'name' => 'CUPOS',
        ]);

        return view('settings.index', compact('shopProfile'));
    }

    public function update(Request $request)
    {
        $shopProfile = ShopProfile::first() ?? new ShopProfile();

        $validated = $request->validate([
            'name'                       => ['required', 'string', 'max:255'],
            'address'                    => ['nullable', 'string', 'max:1000'],
            'phone'                      => ['nullable', 'string', 'max:20'],
            'receipt_footer'             => ['nullable', 'string', 'max:500'],
            'logo'                       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tax_percentage'             => ['nullable', 'numeric', 'min:0', 'max:100'],
            'service_charge_percentage'  => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        if ($request->hasFile('logo')) {
            if ($shopProfile->logo) {
                Storage::disk('public')->delete($shopProfile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $shopProfile->fill($validated);
        $shopProfile->save();

        return redirect()
            ->route('settings.index')
            ->with('status', 'Profil kedai berhasil diperbarui.');
    }

    public function personalization()
    {
        $shopProfile = ShopProfile::first() ?? ShopProfile::create([
            'name' => 'CUPOS',
        ]);

        return view('settings.personalization', compact('shopProfile'));
    }

    public function updatePersonalization(Request $request)
    {
        $shopProfile = ShopProfile::first() ?? new ShopProfile();

        // Regex memastikan format selalu #RRGGBB, mencegah nilai
        // rusak yang bisa membuat CSS variable di layout gagal parse.
        $validated = $request->validate([
            'primary_color'     => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'sidebar_color'     => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'sidebar_text_mode' => ['required', 'in:light,dark'],
            'body_color'        => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $shopProfile->fill($validated);
        $shopProfile->save();

        return redirect()
            ->route('settings.personalization')
            ->with('status', 'Tema warna berhasil diperbarui.');
    }
}

