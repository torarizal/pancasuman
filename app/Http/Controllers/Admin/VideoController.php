<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Services\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Tampilkan daftar tautan video di dashboard admin.
     */
    public function index()
    {
        $videos = Video::with('user')->latest()->paginate(12);

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Form tambah tautan video baru.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Simpan tautan video baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => ['required', 'url'],
            'description' => ['nullable', 'string', 'max:1000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul video wajib diisi.',
            'video_url.required' => 'Tautan video (YouTube atau medsos) wajib diisi.',
            'video_url.url' => 'Format tautan video tidak valid.',
        ]);

        // Ekstraksi otomatis platform, embed URL, dan thumbnail bawaan (jika YouTube)
        $meta = Video::extractMeta($validated['video_url']);

        $thumbnailPath = $meta['thumbnail'];

        // Jika admin mengunggah thumbnail kustom manual
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = ImageOptimizer::optimizeAndStore(
                $request->file('thumbnail'),
                'videos',
                maxWidth: 800,
                quality: 85
            );
        }

        Video::create([
            'title' => $validated['title'],
            'video_url' => $validated['video_url'],
            'embed_url' => $meta['embed_url'],
            'platform' => $meta['platform'],
            'thumbnail' => $thumbnailPath,
            'description' => $validated['description'] ?? null,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Tautan video kegiatan berhasil ditambahkan ke portal.');
    }

    /**
     * Form edit tautan video.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Perbarui data video di database.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'video_url' => ['required', 'url'],
            'description' => ['nullable', 'string', 'max:1000'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $meta = Video::extractMeta($validated['video_url']);

        $data = [
            'title' => $validated['title'],
            'video_url' => $validated['video_url'],
            'embed_url' => $meta['embed_url'],
            'platform' => $meta['platform'],
            'description' => $validated['description'] ?? null,
        ];

        // Jika URL berubah dan thumbnail bawaan belum ada yang kustom
        if ($meta['thumbnail'] && ! str_starts_with($video->thumbnail ?? '', 'videos/')) {
            $data['thumbnail'] = $meta['thumbnail'];
        }

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail && str_starts_with($video->thumbnail, 'videos/') && Storage::disk('public')->exists($video->thumbnail)) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $data['thumbnail'] = ImageOptimizer::optimizeAndStore(
                $request->file('thumbnail'),
                'videos',
                maxWidth: 800,
                quality: 85
            );
        }

        $video->update($data);

        return redirect()->route('admin.videos.index')
            ->with('success', 'Data video berhasil diperbarui.');
    }

    /**
     * Hapus tautan video dari database.
     */
    public function destroy(Video $video)
    {
        if ($video->thumbnail && str_starts_with($video->thumbnail, 'videos/') && Storage::disk('public')->exists($video->thumbnail)) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        return redirect()->route('admin.videos.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
