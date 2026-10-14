<?php

namespace App\Http\Controllers\Admin\Developer;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan umum website & upload logo.
     */
    public function index()
    {
        $siteLogo = Setting::get('site_logo');
        $siteName = Setting::get('site_name', 'Pancasuman');
        $siteTagline = Setting::get('site_tagline', 'Portal Berita & Informasi Pancasuman');

        return view('developer.settings.index', compact('siteLogo', 'siteName', 'siteTagline'));
    }

    /**
     * Perbarui logo website.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ], [
            'logo.required' => 'Pilih berkas logo terlebih dahulu.',
            'logo.image' => 'Berkas harus berupa gambar valid.',
            'logo.mimes' => 'Format logo harus JPG, PNG, WEBP, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        $oldLogo = Setting::get('site_logo');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        $file = $request->file('logo');

        if ($file->getClientOriginalExtension() === 'svg') {
            $path = $file->store('settings', 'public');
        } else {
            $path = ImageOptimizer::optimizeAndStore(
                $file,
                'settings',
                maxWidth: 600,
                quality: 90
            );
        }

        Setting::set('site_logo', $path);

        return redirect()->route('admin.developer.settings.index')
            ->with('success', 'Logo website berhasil diperbarui dan kini tampil di seluruh halaman portal!');
    }

    /**
     * Hapus logo website dan kembali ke logo teks bawaan.
     */
    public function destroyLogo()
    {
        $oldLogo = Setting::get('site_logo');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        Setting::remove('site_logo');

        return redirect()->route('admin.developer.settings.index')
            ->with('success', 'Logo website telah dihapus. Portal kini kembali menggunakan logo teks standar.');
    }
}
