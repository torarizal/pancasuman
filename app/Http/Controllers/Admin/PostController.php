<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Series;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected function userIsDeveloper(): bool
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        if (method_exists($user, 'isDeveloper')) {
            return (bool) $user->isDeveloper();
        }

        if (method_exists($user, 'hasRole')) {
            return (bool) $user->hasRole('developer');
        }

        if (property_exists($user, 'role')) {
            return strtolower((string) $user->role) === 'developer';
        }

        return false;
    }

    public function index()
    {
        // CEK HAK AKSES: Jika Developer, tampilkan SEMUA artikel. Jika penulis biasa, HANYA artikel miliknya sendiri.
        if ($this->userIsDeveloper()) {
            $posts = Post::with(['category', 'series', 'author'])->latest()->paginate(10);
        } else {
            $posts = Post::with(['category', 'series', 'author'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(10);
        }

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
{
    $categories = Category::where('status', 'active')->get();
    
    // Penulis hanya bisa memilih series miliknya sendiri (atau semua jika developer)
    if ($this->userIsDeveloper()) {
        $seriesList = Series::where('status', 'active')->get();
    } else {
        $seriesList = Series::where('status', 'active')
                            ->where('user_id', Auth::id())
                            ->get();
    }

    return view('admin.posts.create', compact('categories', 'seriesList'));
}

   public function store(StorePostRequest $request)
{
    $data = $request->validated();

    if (!empty($data['series_id']) && !empty($data['volume_number'])) {
        // Cari tahu volume tertinggi yang saat ini sudah ada di series tersebut
        $lastPostInSeries = Post::where('series_id', $data['series_id'])->orderBy('volume_number', 'desc')->first();
        $lastVolume = $lastPostInSeries ? $lastPostInSeries->volume_number : 0;
        
        $expectedVolume = $lastVolume + 1;

        // 1. Cek jika nomor volume kembar (sudah ada)
        $exists = Post::where('series_id', $data['series_id'])
                    ->where('volume_number', $data['volume_number'])
                    ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'volume_number' => "Nomor Volume {$data['volume_number']} sudah ada! Volume terakhir di series ini adalah Vol. {$lastVolume}."
            ]);
        }

        // 2. Cek jika penulis LOMPAT VOLUME (Misal harusnya Vol. 11, tapi dia nulis Vol. 15)
        if ($data['volume_number'] > $expectedVolume) {
            return back()->withInput()->withErrors([
                'volume_number' => "Nomor volume melompat! Volume terakhir adalah Vol. {$lastVolume}. Seharusnya urutan berikutnya adalah **Vol. {$expectedVolume}** (kamu mengisi Vol. {$data['volume_number']})."
            ]);
        }
    }

    if (empty($data['slug'])) {
        unset($data['slug']);
    }

    // Upload Featured Image jika ada
    if ($request->hasFile('featured_image')) {
        $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
    }

    $data['user_id'] = Auth::id();

    Post::create($data);

    return redirect()->route('admin.posts.index')
        ->with('success', 'Artikel/Cerpen berhasil ditambahkan.');
}

    public function edit(Post $post)
{
    if (!$this->userIsDeveloper() && $post->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }

    $categories = Category::where('status', 'active')->get();
    
    if ($this->userIsDeveloper()) {
        $seriesList = Series::where('status', 'active')->get();
    } else {
        $seriesList = Series::where('status', 'active')
                            ->where('user_id', Auth::id())
                            ->get();
    }

    return view('admin.posts.edit', compact('post', 'categories', 'seriesList'));
}

    public function update(UpdatePostRequest $request, Post $post)
{
    if (!$this->userIsDeveloper() && $post->user_id !== Auth::id()) {
        abort(403, 'Anda tidak memiliki hak akses untuk memperbarui tulisan ini.');
    }

    $data = $request->validated();

    // CEK VOLUME GANDA SAAT EDIT (Kecuali untuk post itu sendiri)
    if (!empty($data['series_id']) && !empty($data['volume_number'])) {
        $exists = Post::where('series_id', $data['series_id'])
                    ->where('volume_number', $data['volume_number'])
                    ->where('id', '!=', $post->id) // Abaikan post yang sedang diedit ini
                    ->exists();

        if ($exists) {
            $lastVolume = Post::where('series_id', $data['series_id'])->max('volume_number');
            $suggested = $lastVolume ? $lastVolume + 1 : 1;

            return back()->withInput()->withErrors([
                'volume_number' => "Nomor Volume {$data['volume_number']} sudah dipakai artikel lain di series ini! Saran volume berikutnya: {$suggested}."
            ]);
        }
    }

    if (empty($data['slug'])) {
        unset($data['slug']);
    }

    // Update Featured Image jika ada file baru diunggah
    if ($request->hasFile('featured_image')) {
        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }
        $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
    }

    $post->update($data);

    return redirect()->route('admin.posts.index')
        ->with('success', 'Artikel/Cerpen berhasil diperbarui.');
}

    public function destroy(Post $post)
    {
        // KEAMANAN: Tolak akses (403) jika mencoba menghapus artikel milik orang lain
        if (!$this->userIsDeveloper() && $post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus tulisan ini.');
        }

        // Hapus file gambar jika ada di storage
        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel/Cerpen berhasil dihapus.');
    }
}