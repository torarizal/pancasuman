<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Category;
use App\Models\Series;
use Illuminate\Support\Facades\Auth;

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
        if (empty($data['slug'])) {
            unset($data['slug']);
        }

        // Paksa user_id diisi oleh ID akun yang sedang login saat ini
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
        // KEAMANAN: Tolak akses (403) jika mencoba update artikel milik orang lain
        if (!$this->userIsDeveloper() && $post->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk memperbarui tulisan ini.');
        }

        $data = $request->validated();
        if (empty($data['slug'])) {
            unset($data['slug']);
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

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel/Cerpen berhasil dihapus.');
    }
}