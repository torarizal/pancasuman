<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Tampilkan daftar foto kegiatan di dashboard admin.
     */
    public function index()
    {
        $galleries = Gallery::with('user')->latest('activity_date')->latest()->paginate(12);

        return view('admin.galleries.index', compact('galleries'));
    }

    /**
     * Form tambah foto kegiatan baru.
     */
    public function create()
    {
        return view('admin.galleries.create');
    }

    /**
     * Simpan foto kegiatan baru ke penyimpanan publik & database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'activity_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [
            'title.required' => 'Nama kegiatan wajib diisi.',
            'image.required' => 'Pilih foto kegiatan yang ingin diunggah.',
            'image.image' => 'Berkas harus berupa gambar valid.',
            'image.max' => 'Ukuran foto maksimal 5MB.',
        ]);

        // Kompresi otomatis gambar ke WebP 80% kualitas
        $path = ImageOptimizer::optimizeAndStore(
            $request->file('image'),
            'galleries',
            maxWidth: 1400,
            quality: 80
        );

        Gallery::create([
            'title' => $validated['title'],
            'image' => $path,
            'activity_date' => $validated['activity_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil ditambahkan ke galeri.');
    }

    /**
     * Form edit foto kegiatan.
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    /**
     * Perbarui foto kegiatan di database.
     */
    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'activity_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $data = [
            'title' => $validated['title'],
            'activity_date' => $validated['activity_date'] ?? null,
            'description' => $validated['description'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $data['image'] = ImageOptimizer::optimizeAndStore(
                $request->file('image'),
                'galleries',
                maxWidth: 1400,
                quality: 80
            );
        }

        $gallery->update($data);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil diperbarui.');
    }

    /**
     * Hapus foto kegiatan dari storage dan database.
     */
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Foto kegiatan berhasil dihapus dari galeri.');
    }
}
